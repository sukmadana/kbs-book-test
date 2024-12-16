<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/books', [App\Http\Controllers\Api\BookController::class, 'index']);
    Route::post('/books', [App\Http\Controllers\Api\BookController::class, 'store']);
    Route::get('/books/{id}', [App\Http\Controllers\Api\BookController::class, 'show']);
    Route::put('/books/{id}', [App\Http\Controllers\Api\BookController::class, 'update']);
    Route::delete('/books/{id}', [App\Http\Controllers\Api\BookController::class, 'destroy']);

    Route::get('/book-category', [App\Http\Controllers\Api\CategoryController::class, 'index']);
    Route::post('/book-category', [App\Http\Controllers\Api\CategoryController::class, 'store']);
    Route::get('/book-category/{id}', [App\Http\Controllers\Api\CategoryController::class, 'show']);
    Route::put('/book-category/{id}', [App\Http\Controllers\Api\CategoryController::class, 'update']);
    Route::delete('/book-category/{id}', [App\Http\Controllers\Api\CategoryController::class, 'destroy']);

    Route::get('/authors', [App\Http\Controllers\Api\AuthorController::class, 'index']);
    Route::post('/authors', [App\Http\Controllers\Api\AuthorController::class, 'store']);
    Route::get('/authors/{id}', [App\Http\Controllers\Api\AuthorController::class, 'show']);
    Route::put('/authors/{id}', [App\Http\Controllers\Api\AuthorController::class, 'update']);
    Route::delete('/authors/{id}', [App\Http\Controllers\Api\AuthorController::class, 'destroy']);
});
