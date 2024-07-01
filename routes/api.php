<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [RegisterController::class, 'register']);
Route::post('send-code', [VerifyEmailController::class, 'sendCode']);
Route::post('verify-email', [VerifyEmailController::class, 'verifyEmail']);
Route::post('login', [LoginController::class, 'login']);


Route::prefix('product')->name('product.')->group(function () {
    Route::get('/', [ProductController::class,'index'])->name('index');
    Route::post('/', [ProductController::class,'store'])->name('store');
    Route::get('/{product}', [ProductController::class,'show'])->name('show');
    Route::put('/{product}', [ProductController::class,'update'])->name('update');
    Route::delete('/{product}', [ProductController::class,'destroy'])->name('destroy');
});

