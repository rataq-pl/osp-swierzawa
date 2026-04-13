<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PingController;
use App\Http\Controllers\Api\V1\BlogController;

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
