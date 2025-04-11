<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WallpaperController;
use App\Http\Controllers\CategoryController;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/verify-otp',[AuthController::class,'verifyOtp']);
Route::post('/reset-password',[AuthController::class,'resetPasswordOTP']);
Route::post('/confirm-password',[AuthController::class,'resetPasswordWithOtp']);

Route::get('/user',[ProfileController::class,'index']);
Route::get('/test-api', function () {
    return response()->json(['message' => 'API is working']);
});

Route::get('/wallpaper',[WallpaperController::class,'index']);
Route::post('/wallpaper/store',[WallpaperController::class,'store']);
Route::post('/wallpaper/update/{id}',[WallpaperController::class,'update']);
Route::get('/wallpaper/show/{id}',[WallpaperController::class,'show']);
Route::delete('/wallpaper/{id}',[WallpaperController::class,'destroy']);

Route::get('/category',[CategoryController::class,'index']);
Route::post('/category/store',[CategoryController::class,'store']);
Route::post('/category/update/{id}',[CategoryController::class,'update']);
Route::get('/category/show/{id}',[CategoryController::class,'show']);
Route::delete('/category/{id}',[CategoryController::class,'destroy']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/user/{id}',[ProfileController::class,'show']);
    Route::post('/user/update/{id}',[ProfileController::class,'update']);
    Route::post('/logout',[AuthController::class,'logout']);
});
