<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WallpaperController;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/verify-otp',[AuthController::class,'verifyOtp']);
Route::post('/reset-password',[AuthController::class,'resetPasswordOTP']);
Route::post('/confirm-password',[AuthController::class,'resetPasswordWithOtp']);

Route::get('/user',[ProfileController::class,'index']);
Route::get('/test-api', function () {
    return response()->json(['message' => 'API is working']);
});

//Route::post('/product',[ProductController::class,'store']);
Route::get('/wallpaper',[WallpaperController::class,'index']);
Route::post('/wallpaper/store',[WallpaperController::class,'store']);
Route::post('/wallpaper/update/{id}',[WallpaperController::class,'update']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/user/{id}',[ProfileController::class,'show']);
    Route::post('/user/update/{id}',[ProfileController::class,'update']);
    Route::post('/logout',[AuthController::class,'logout']);
});
