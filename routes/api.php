<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// Route::get('/dashboard', [AuthController::class, 'index']);
// Route::get('/login', [AuthController::class, 'loginPage']);
// Route::post('/login', [AuthController::class, 'login']);
// //Route::get('/register', [AuthController::class, 'register']);
// Route::get('/register', [AuthController::class, 'register'])->name('register.form');
// Route::post('/register', [AuthController::class, 'store'])->name('register.store');
// Route::post('logout', LogoutController::class);
Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
Route::apiresource('/posts', PostController::class);
