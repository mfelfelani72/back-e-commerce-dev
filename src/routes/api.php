<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminCategoryController;

Route::get('/user', function (Request $request) {
    
    return $request->user();
})->middleware('auth:sanctum');


// Admin

Route::post('/admin/category/store', [AdminCategoryController::class, 'store']);
Route::post('/admin/category/categories', [AdminCategoryController::class, 'categories']);

// Auth

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


