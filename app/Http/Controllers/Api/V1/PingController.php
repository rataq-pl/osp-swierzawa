<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class PingController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'API is running',
            'timestamp' => now()->toIso8601String(),
            'version' => 'v1'
        ]);
    }
}
