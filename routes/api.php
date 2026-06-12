<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CandidateController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ContentsController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Controller;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);
Route::post('/forgot-password', [LoginController::class, 'forgotPassword']);

Route::resource('/candidate', CandidateController::class);
Route::resource('/categories', CategoriesController::class);
Route::prefix('categories')->group(function () {
    Route::post('/create-multiple', [CategoriesController::class, 'create_multiple']);
});
Route::resource('/contents', ContentsController::class);

Route::prefix('contents')->group(function () {
    Route::post('/create-multiple', [ContentsController::class, 'create_multiple']);
});

Route::get('/send-test-mail', [Controller::class, 'test_send_mail']);
Route::get('/send-mail-information', [Controller::class, 'send_account_info_mail']);