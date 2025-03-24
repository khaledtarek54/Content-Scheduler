<?php


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\PostPlatformController;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum','throttle:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('/profile', [UserProfileController::class, 'show']);
    Route::put('/profile', [UserProfileController::class, 'update']);

    Route::get('posts', [PostController::class, 'index']);
    Route::get('posts/{id}', [PostController::class, 'fetchPostById']);
    Route::post('posts', [PostController::class, 'store']);
    Route::put('posts/{id}', [PostController::class, 'update']);
    Route::delete('posts/{id}', [PostController::class, 'destroy']);

    Route::get('/platforms', [PlatformController::class, 'index']);
    Route::post('/platforms/{platformId}/toggle', [PlatformController::class, 'togglePlatform']);
    Route::get('/suggested-time/{platformId}', [PlatformController::class, 'getSuggestedTime']);

    Route::post('/posts/{postId}/platforms', [PostPlatformController::class, 'attachPlatforms']);

    Route::get('/analytics', [AnalyticsController::class, 'getPostAnalytics']);

});
