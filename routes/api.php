<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Get all products
Route::get('/products', [ProductController::class, 'index']);

// Store a new product
Route::post('/products', [ProductController::class, 'store']);

// Get a specific product by ID
Route::get('/products/{product}', [ProductController::class, 'show']);

// Update a product
Route::post('/products/update/{product}', [ProductController::class, 'update']);

// Delete a product
Route::delete('/products/{product}', [ProductController::class, 'destroy']);

// Get all categories
Route::get('/categories', [CategoryController::class, 'index']);

// Store a new category
Route::post('/categories', [CategoryController::class, 'store']);

// Get a specific category by ID
Route::get('/categories/{category}', [CategoryController::class, 'show']);

// Update a category
Route::post('/categories/update/{category}', [CategoryController::class, 'update']);

// Delete a category
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
