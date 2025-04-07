<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/verify-otp',[AuthController::class,'verifyOtp']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout',[AuthController::class,'logout']);
});
