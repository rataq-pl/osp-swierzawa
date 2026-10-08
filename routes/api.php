<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PingController;
use App\Http\Controllers\Api\V1\BlogController;
use App\Http\Controllers\Konkursy;
use App\Http\Controllers\Glowna;

// Endpointy AJAX strony (public/js/rataqPLtesty.js, public/js/wpisy.js)
Route::post('pobierzPytania/{url}', [Konkursy::class, 'pobierzPytania']);
Route::post('startPytan', [Konkursy::class, 'startPytan']);
Route::post('aktualizujOdpowiedzi', [Konkursy::class, 'aktualizujOdpowiedzi']);
Route::post('oznaczGotowy', [Konkursy::class, 'oznaczGotowy']);
Route::post('wyslijWyniki', [Konkursy::class, 'wyslijWyniki']);
Route::post('pobierzStarsze', [Glowna::class, 'pobierzStarsze']);

// Public endpoints
Route::prefix('v1')->group(function () {
    Route::get('ping', [PingController::class, 'index']);
});

// Protected endpoints
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    // Blog endpoints
    Route::get('blog', [BlogController::class, 'index'])->middleware('ability:blog:read,*');
    Route::get('blog/{id}', [BlogController::class, 'show'])->middleware('ability:blog:read,*');
    Route::post('blog', [BlogController::class, 'store'])->middleware('ability:blog:create,*');
    Route::put('blog/{id}', [BlogController::class, 'update'])->middleware('ability:blog:update,*');
    Route::delete('blog/{id}', [BlogController::class, 'destroy'])->middleware('ability:blog:delete,*');
    Route::patch('blog/{id}/status', [BlogController::class, 'updateStatus'])->middleware('ability:blog:update,*');
    Route::post('blog/upload-image', [BlogController::class, 'uploadImage'])->middleware('ability:blog:create,*');
});
