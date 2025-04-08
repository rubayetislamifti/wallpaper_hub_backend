<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/verify-otp',[AuthController::class,'verifyOtp']);
Route::post('/reset-password',[AuthController::class,'resetPasswordOTP']);
Route::post('/confirm-password',[AuthController::class,'resetPasswordWithOtp']);



Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/user/{id}',[ProfileController::class,'show']);
    Route::post('/logout',[AuthController::class,'logout']);
});
