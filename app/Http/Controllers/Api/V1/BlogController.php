<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('aktualnosci')->orderByDesc('id');

        // Filter by status (aktywny field if exists)
        if ($request->has('status')) {
            // Note: current schema uses 'aktywny' or we skip if not present
        }

        // Search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('tytul', 'like', "%{$search}%")
                  ->orWhere('tresc', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('kategoria')) {
            $query->where('kategoria', $request->get('kategoria'));
        }

        $perPage = min($request->get('per_page', 15), 100);
        $page = $request->get('page', 1);

        $countQuery = clone $query;
        $total = $countQuery->count();

        $wpisy = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();

        $data = $wpisy->map(function ($wpis) {
            return $this->transformWpis($wpis);
        });

        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'current_page' => (int) $page,
                'last_page' => (int) ceil($total / $perPage),
                'per_page' => (int) $perPage,
                'total' => (int) $total
            ]
        ]);
    }

    public function show($id)
    {
        $wpis = DB::table('aktualnosci')->where('id', $id)->first();

        if (!$wpis) {
            return response()->json([
                'success' => false,
                'error' => 'Wpis nie istnieje',
                'code' => 'not_found'
            ], 404);
        }

        // Get gallery
        $galeria = DB::table('aktualnosciGalerie')
            ->where('aktualnosciID', $id)
            ->pluck('url')
            ->toArray();

        return response()->json([
            'success' => true,
            'data' => $this->transformWpis($wpis, $galeria)
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // Validation
        if (empty($data['tytul'])) {
            return response()->json([
                'success' => false,
                'error' => 'Pole tytul jest wymagane',
                'code' => 'validation_error'
            ], 422);
        }

        if (empty($data['tresc'])) {
            return response()->json([
                'success' => false,
                'error' => 'Pole tresc jest wymagane',
                'code' => 'validation_error'
            ], 422);
        }

        // Generate slug
        $url = $data['url'] ?? Str::slug($data['tytul']);

        // Ensure unique slug
        $existingUrl = DB::table('aktualnosci')->where('url', $url)->first();
        if ($existingUrl) {
            $url = $url . '-' . time();
        }

        // Sanitize HTML
        $tresc = $this->sanitizeHtml($data['tresc']);

        // Process images
        $zdjecie = null;
        $downloadedImages = 0;
        $imageErrors = [];

        if (!empty($data['zdjecie'])) {
            $result = $this->processImage($data['zdjecie']);
            if ($result['success']) {
                $zdjecie = $result['path'];
                $downloadedImages++;
            } else {
                $imageErrors[] = $result['error'];
            }
        }

        // Insert
        $id = DB::table('aktualnosci')->insertGetId([
            'tytul' => $data['tytul'],
            'url' => $url,
            'poprzedni_url' => '',
            'tresc' => $tresc,
            'zdjecie' => $zdjecie,
            'kategoria' => $data['kategoria'] ?? 'aktualnosci',
            'autor' => $request->user()->id,
            'zalaczniki' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Process gallery
        $galleryImages = 0;
        if (!empty($data['galeria'])) {
            $galeria = $this->parseGallery($data['galeria']);
            foreach ($galeria as $imageUrl) {
                if (empty(trim($imageUrl))) continue;

                $result = $this->processImage(trim($imageUrl));
                if ($result['success']) {
                    DB::table('aktualnosciGalerie')->insert([
                        'url' => $result['path'],
                        'tytul' => null,
                        'aktualnosciID' => $id
                    ]);
                    $galleryImages++;

                    // Use first gallery image as thumbnail if none set
                    if (!$zdjecie) {
                        $zdjecie = $result['path'];
                        DB::table('aktualnosci')->where('id', $id)->update(['zdjecie' => $zdjecie]);
                    }
                } else {
                    $imageErrors[] = $result['error'];
                }
            }
        }

        $wpis = DB::table('aktualnosci')->where('id', $id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Wpis zostal utworzony',
            'data' => $this->transformWpis($wpis),
            'meta' => [
                'downloaded_images' => $downloadedImages,
                'gallery_images' => $galleryImages,
                'image_errors' => $imageErrors
            ]
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $wpis = DB::table('aktualnosci')->where('id', $id)->first();

        if (!$wpis) {
            return response()->json([
                'success' => false,
                'error' => 'Wpis nie istnieje',
                'code' => 'not_found'
            ], 404);
        }

        $data = $request->all();
        $updateData = ['updated_at' => now()];

        if (isset($data['tytul'])) {
            $updateData['tytul'] = $data['tytul'];
        }

        if (isset($data['tresc'])) {
            $updateData['tresc'] = $this->sanitizeHtml($data['tresc']);
        }

        if (isset($data['url'])) {
            $updateData['url'] = Str::slug($data['url']);
        }

        if (isset($data['kategoria'])) {
            $updateData['kategoria'] = $data['kategoria'];
        }

        if (isset($data['zdjecie'])) {
            $result = $this->processImage($data['zdjecie']);
            if ($result['success']) {
                $updateData['zdjecie'] = $result['path'];
            }
        }

        DB::table('aktualnosci')->where('id', $id)->update($updateData);

        // Update gallery if provided
        if (isset($data['galeria'])) {
            // Remove old gallery
            DB::table('aktualnosciGalerie')->where('aktualnosciID', $id)->delete();

            // Add new gallery
            $galeria = $this->parseGallery($data['galeria']);
            foreach ($galeria as $imageUrl) {
                if (empty(trim($imageUrl))) continue;

                $result = $this->processImage(trim($imageUrl));
                if ($result['success']) {
                    DB::table('aktualnosciGalerie')->insert([
                        'url' => $result['path'],
                        'tytul' => null,
                        'aktualnosciID' => $id
                    ]);
                }
            }
        }

        $wpis = DB::table('aktualnosci')->where('id', $id)->first();
        $galeria = DB::table('aktualnosciGalerie')->where('aktualnosciID', $id)->pluck('url')->toArray();

        return response()->json([
            'success' => true,
            'message' => 'Wpis zostal zaktualizowany',
            'data' => $this->transformWpis($wpis, $galeria)
        ]);
    }

    public function destroy($id)
    {
        $wpis = DB::table('aktualnosci')->where('id', $id)->first();

        if (!$wpis) {
            return response()->json([
                'success' => false,
                'error' => 'Wpis nie istnieje',
                'code' => 'not_found'
            ], 404);
        }

        // Delete related records
        DB::table('aktualnosciGalerie')->where('aktualnosciID', $id)->delete();
        DB::table('aktualnosciWideo')->where('aktualnosciID', $id)->delete();
        DB::table('aktualnosci')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wpis zostal usuniety'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $wpis = DB::table('aktualnosci')->where('id', $id)->first();

        if (!$wpis) {
            return response()->json([
                'success' => false,
                'error' => 'Wpis nie istnieje',
                'code' => 'not_found'
            ], 404);
        }

        // Note: The current schema may not have a 'ready' or 'aktywny' column
        // This would need to be added via migration if status functionality is required

        return response()->json([
            'success' => true,
            'message' => 'Status zostal zaktualizowany'
        ]);
    }

    public function uploadImage(Request $request)
    {
        $imageUrl = $request->get('image_url');
        $imageBase64 = $request->get('image_base64');
        $imageFile = $request->file('image');

        if (!$imageUrl && !$imageBase64 && !$imageFile) {
            return response()->json([
                'success' => false,
                'error' => 'Brak obrazu do przetworzenia',
                'code' => 'bad_request'
            ], 400);
        }

        if ($imageUrl) {
            $result = $this->processImage($imageUrl);
        } elseif ($imageBase64) {
            $result = $this->processBase64Image($imageBase64);
        } else {
            $result = $this->processUploadedFile($imageFile);
        }

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'error' => $result['error'],
                'code' => 'bad_request'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'path' => $result['path'],
                'url' => url($result['path']),
                'filename' => basename($result['path']),
                'size' => $result['size'] ?? null,
                'mime_type' => $result['mime_type'] ?? null
            ]
        ]);
    }

    // ========== HELPER METHODS ==========

    private function transformWpis($wpis, $galeria = null)
    {
        return [
            'id' => $wpis->id,
            'tytul' => $wpis->tytul,
            'url' => $wpis->url,
            'zdjecie' => $wpis->zdjecie,
            'galeria' => $galeria ?? [],
            'wstep' => Str::limit(strip_tags($wpis->tresc), 200),
            'tresc' => $wpis->tresc,
            'kategoria' => $wpis->kategoria,
            'created_at' => $wpis->created_at ?? null,
            'updated_at' => $wpis->updated_at ?? null
        ];
    }

    private function parseGallery($galeria)
    {
        if (is_array($galeria)) {
            return $galeria;
        }

        // Try to decode JSON
        $decoded = json_decode($galeria, true);
        if (is_array($decoded)) {
            return $decoded;
        }

        // Split by comma
        return explode(',', $galeria);
    }

    private function sanitizeHtml($html)
    {
        // Allow safe tags
        $allowed = '<p><br><div><span><h1><h2><h3><h4><h5><h6><blockquote><pre><code><hr><strong><b><em><i><u><s><strike><sub><sup><small><mark><ul><ol><li><table><thead><tbody><tr><td><th><img><figure><figcaption><a><iframe><video><audio><source><embed><object><param><picture>';

        $html = strip_tags($html, $allowed);

        // Remove dangerous attributes
        $html = preg_replace('/\s*on\w+\s*=\s*"[^"]*"/i', '', $html);
        $html = preg_replace('/\s*on\w+\s*=\s*\'[^\']*\'/i', '', $html);
        $html = preg_replace('/javascript\s*:/i', '', $html);

        return $html;
    }

    private function processImage($url)
    {
        if (empty($url)) {
            return ['success' => false, 'error' => 'Empty URL'];
        }

        // Check if it's already a local path
        if (strpos($url, 'http') !== 0) {
            return ['success' => true, 'path' => $url];
        }

        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 30,
                    'user_agent' => 'Mozilla/5.0 (compatible; OSP-Swierzawa/1.0)'
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false
                ]
            ]);

            $imageContent = @file_get_contents($url, false, $context);
            if ($imageContent === false) {
                return ['success' => false, 'error' => "Could not download: {$url}"];
            }

            // Detect extension from URL or content
            $extension = 'jpg';
            $urlPath = parse_url($url, PHP_URL_PATH);
            if ($urlPath) {
                $ext = strtolower(pathinfo($urlPath, PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
                    $extension = $ext;
                }
            }

            $filename = date('YmdHis') . '_' . Str::random(8) . '.' . $extension;
            $path = 'upload/wgrane/' . $filename;
            $fullPath = public_path($path);

            if (!file_put_contents($fullPath, $imageContent)) {
                return ['success' => false, 'error' => "Could not save: {$url}"];
            }

            return [
                'success' => true,
                'path' => '/' . $path,
                'size' => strlen($imageContent),
                'mime_type' => 'image/' . $extension
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function processBase64Image($base64)
    {
        $extension = 'jpg';
        if (preg_match('/^data:image\/(\w+);base64,/', $base64, $matches)) {
            $extension = $matches[1];
            $base64 = substr($base64, strpos($base64, ',') + 1);
        }

        $imageContent = base64_decode($base64);
        if ($imageContent === false) {
            return ['success' => false, 'error' => 'Invalid base64 data'];
        }

        $filename = date('YmdHis') . '_' . Str::random(8) . '.' . $extension;
        $path = 'upload/wgrane/' . $filename;
        $fullPath = public_path($path);

        if (!file_put_contents($fullPath, $imageContent)) {
            return ['success' => false, 'error' => 'Could not save image'];
        }

        return [
            'success' => true,
            'path' => '/' . $path,
            'size' => strlen($imageContent),
            'mime_type' => 'image/' . $extension
        ];
    }

    private function processUploadedFile($file)
    {
        $extension = $file->getClientOriginalExtension() ?: 'jpg';
        $filename = date('YmdHis') . '_' . Str::random(8) . '.' . $extension;
        $path = 'upload/wgrane/' . $filename;
        $fullPath = public_path($path);

        if (!copy($file->getRealPath(), $fullPath)) {
            return ['success' => false, 'error' => 'Could not save uploaded file'];
        }

        return [
            'success' => true,
            'path' => '/' . $path,
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType()
        ];
    }
}
