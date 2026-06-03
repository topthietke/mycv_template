<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ContentsController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;



Route::get('/login', [LoginController::class, 'form_login'])->name('login');    
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [LoginController::class, 'form_register'])->name('register');    
Route::post('/register', [LoginController::class, 'register']);

Route::post('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot.password');



Route::resource('/candidate', CandidateController::class);
Route::resource('/categories', CategoriesController::class);
Route::resource('/contents', ContentsController::class);
