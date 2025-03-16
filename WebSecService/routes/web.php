<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\StudentController;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/multable', function () {
    return view('Calculate.multable');
});

Route::get('/even', function () {
    return view('Calculate.even');
});

Route::get('/prime', function () {
    return view('Calculate.prime');
});

Route::get('/multiplication', function () {
    return view('Calculate.multiplication');
});

Route::get('/bill', function () {
    return view('Calculate.bill');
});


Route::get('/profile/details', [ProfileController::class, 'details'])->name('profile.details');
Route::post('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

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

Route::get('products', [ProductsController::class, 'list'])->name('products.list'); // Ensure this route is correctly defined

Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');

Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');

Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');

Route::get('register', [ProfileController::class, 'register'])->name('register');
Route::post('register', [ProfileController::class, 'doRegister'])->name('do_register');
Route::get('profile/{user?}', [ProfileController::class, 'profile'])->name('profile');
Route::get('users/edit/{user?}', [ProfileController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user}', [ProfileController::class, 'save'])->name('users_save');

 Route::get('/student', [StudentController::class, 'index'])->name('student.index');
Route::middleware(['auth'])->group(function () {

    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/student', [StudentController::class, 'store'])->name('student.store');
});
