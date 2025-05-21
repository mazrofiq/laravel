<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/user', [UserController::class, 'show']);
Route::post('/authorization/v1/access-token/b2b', [UserController::class, 'b2bToken']);