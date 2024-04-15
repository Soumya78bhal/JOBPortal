<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/register',[AccountController::class,'registration'])->name('register');
Route::get('/login',[AccountController::class,'login'])->name('login');
Route::post('/processregister',[AccountController::class,'processregister'])->name('processregister');
Route::post('/authenticate',[AccountController::class,'authenticate'])->name('authenticate');
Route::get('/profile',[AccountController::class,'profile'])->middleware('auth1')->name('profile');
Route::get('/logout',[AccountController::class,'logout'])->name('logout');

