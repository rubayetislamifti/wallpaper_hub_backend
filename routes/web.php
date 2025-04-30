<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UddoktapayController;

Route::get('/', function () {
    return view("welcome");
});

Route::get( 'pay', [UddoktapayController::class, 'show'] )->name( 'uddoktapay.payment-form' );
Route::post( 'pay', [UddoktapayController::class, 'pay'] )->name( 'uddoktapay.pay' );
Route::get( 'success', [UddoktapayController::class, 'success'] )->name( 'uddoktapay.success' );
Route::get( 'cancel', [UddoktapayController::class, 'cancel'] )->name( 'uddoktapay.cancel' );
