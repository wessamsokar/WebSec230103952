<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;


Route::middleware(['auth'])->group(function () {
    Route::get('/welcome', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/multable', function () {
        return view('multable');
    });

    Route::get('/even', function () {
        return view('even');
    });

    Route::get('/prime', function () {
        return view('prime');
    });

    Route::get('/multiplication', function () {
        return view('multiplication');
    });

    Route::get('/bill', function () {
        return view('bill');
    });

    Route::get('/student', function () {
        return view('student');
    });

    Route::get('/profile/details', [ProfileController::class, 'details'])->name('profile.details');
    Route::post('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});

Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');

Route::get('/login', function () {
    return view('auth.login');
})->name('login.form');
Route::post('/login', [ProfileController::class, 'login'])->name('login');
Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
