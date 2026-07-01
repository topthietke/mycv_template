<?php

use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    } else {
        return redirect()->route('login');
    }
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [LoginController::class, 'form_register'])->name('auth.register');
    Route::get('/login', [LoginController::class, 'form_login'])->name('login');
    Route::get('/forgot-password', [LoginController::class, 'forgot_password'])->name('forgot.password');

    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::post('/register', [LoginController::class, 'register']);
    Route::post('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot.password.post');


});



Route::middleware('check.login')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/edit/{candidate_id}', [HomeController::class, 'edit'])->name('edit');
});


