<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/books', [BookController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/books/{id}', [BookController::class, 'show'])->middleware(['auth:sanctum']);
Route::post('/books', [BookController::class, 'store'])->middleware(['auth:sanctum']);
Route::put('/books/{id}', [BookController::class, 'update'])->middleware(['auth:sanctum']);
Route::delete('/books/{id}', [BookController::class, 'destroy'])->middleware(['auth:sanctum']);

Route::get('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);


