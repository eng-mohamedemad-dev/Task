<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SessionStateController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

Route::post('/orders', [OrderController::class, 'store']);
Route::post('/session', [SessionStateController::class, 'storeOrUpdate']);
Route::get('/session/{session_id}', [SessionStateController::class, 'show']);
Route::post('/chat', [ChatController::class, 'handle']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('/products', ProductController::class);
});



