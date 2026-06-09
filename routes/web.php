<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/user', [UserController::class, 'show']);
Route::post('/getthreeds', [UserController::class, 'getthreeds'])
    ->name('getthreeds');
Route::get('/payment/charge/{invoice}', [UserController::class, 'paymentCharge']);
Route::get('/payment/failed/{invoice}', [UserController::class, 'paymentFailed']);
Route::post('/charge', [UserController::class, 'charge']);
Route::post('/authorization/v1/access-token/b2b', [UserController::class, 'b2bToken']);
Route::post('/v1.1/transfer-va/inquiry', [UserController::class, 'virtualAccount']);