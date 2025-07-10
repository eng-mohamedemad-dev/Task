<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SessionStateController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

// Route::post('/chat', [ChatController::class, 'handle']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::middleware('role:admin')->apiResource('/sessions', SessionStateController::class);
    Route::apiResource('/orders', OrderController::class);
    Route::apiResource('/products', ProductController::class);
    Route::apiResource('/stores', StoreController::class);
});



