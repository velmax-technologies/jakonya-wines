<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('profile', [AuthController::class, 'profile'])->name('profile');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
