<?php
// use App\Http\Controllers\LoginController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('auth.register');
    return view('auth.register');
});

Route::get('/register', [LoginController::class, 'form_register'])->name('register');
Route::get('/login', [LoginController::class, 'form_login'])->name('login');
Route::get('/forgot-password', [LoginController::class, 'forgot_password'])->name('forgot.password');

// Route::post('/login', [LoginController::class, 'login']);

// Route::get('/register', [LoginController::class, 'form_register'])->name('register');    
// Route::post('/register', [LoginController::class, 'register']);

// Route::post('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot.password');



// Route::resource('/candidate', CandidateController::class);
// Route::resource('/categories', CategoriesController::class);
// Route::resource('/contents', ContentsController::class);
