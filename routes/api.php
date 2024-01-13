<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserContoller;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserContoller::class, 'register']);
Route::post('/login', [UserContoller::class, 'login']);
Route::post('/logout', [UserContoller::class, 'logout']);

Route::resource('products', ProductController::class);
Route::post('/products/{product}/comments', [CommentController::class, 'store'])->middleware('auth:sanctum');

