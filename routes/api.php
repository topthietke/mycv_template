<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CandidateController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ContentsController;
use App\Http\Controllers\LoginController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [LoginController::class, 'form_register'])->name('register');    
Route::post('/register', [LoginController::class, 'register']);
Route::post('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot.password');

Route::resource('/candidate', CandidateController::class);
Route::resource('/categories', CategoriesController::class);
Route::prefix('categories')->group(function () {
    Route::post('/create-multiple', [CategoriesController::class, 'create_multiple']);
});
Route::resource('/contents', ContentsController::class);

Route::prefix('contents')->group(function () {
    Route::post('/create-multiple', [ContentsController::class, 'create_multiple']);
});