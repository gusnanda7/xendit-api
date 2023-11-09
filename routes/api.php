<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\c_payment;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\c_kategori;
use App\Http\Controllers\c_fasilitas;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(c_payment::class)->group(function () {
    Route::post('payment/invoice', 'create')->name('payment.invoice');
	Route::post('payment/bayar', 'bayar')->name('payment.bayar');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('auth/login', 'login')->name('auth.login');
    Route::get('auth/unauth', 'unauth')->name('auth.unauth');
	Route::post('auth/register', 'register')->name('auth.register');
    Route::post('auth/logout', 'logout')->name('auth.logout')->middleware('auth:sanctum');
});

Route::controller(c_kategori::class)->middleware('auth:sanctum')->group(function () {
    Route::post('kategori', 'store')->middleware('role:admin');
    Route::get('kategori/{id}', 'show');
    Route::get('kategori', 'get');
	Route::put('kategori/{id}', 'put')->middleware('role:admin');
    Route::delete('kategori/{id}', 'delete')->middleware('role:admin');
});

Route::controller(c_kategori::class)->middleware('auth:sanctum')->group(function () {
    Route::post('fasilitas', 'store')->middleware('role:admin');
    Route::get('fasilitas/{id}', 'show');
    Route::get('fasilitas', 'get');
	Route::put('fasilitas/{id}', 'put')->middleware('role:admin');
    Route::delete('fasilitas/{id}', 'delete')->middleware('role:admin');
});

// Route::controller(c_payment::class)->middleware('auth:sanctum')->group(function () {
//     Route::post('payment/invoice', 'create')->name('payment.invoice');
// 	Route::post('payment/bayar', 'bayar')->name('payment.bayar');
// });

