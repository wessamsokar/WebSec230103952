<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\StudentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;

Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');
Route::get('users', [UsersController::class, 'list'])->name('users.list');
Route::get('users/create', [UsersController::class, 'create'])->name('users.create');
Route::post('/users/store', [UsersController::class, 'store'])->name('users.store');
Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
Route::get('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete');
Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');
Route::post('/users/change-password', [UsersController::class, 'updatePassword'])->name('users.update-password');
Route::get('/users/change-password', [UsersController::class, 'showChangePasswordForm'])->name('users.change-password');


Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('/products/save/{id?}', [ProductsController::class, 'save'])->name('products_save');
Route::put('/products/save/{id?}', [ProductsController::class, 'save'])->name('products_save');
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');

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

Route::get('/student', [StudentController::class, 'index'])->name('student.index');
Route::middleware(['auth'])->group(function () {
    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/student', [StudentController::class, 'store'])->name('student.store');
    Route::get('student/delete/{student}', [StudentController::class, 'delete'])->name('student_delete');
});


Route::resource('permissions', PermissionController::class);
Route::resource('roles', RoleController::class);



Route::middleware(['auth', 'check.credit'])->group(function () {
    Route::post('/purchase', [UsersController::class, 'purchase'])->name('purchase');
});


use App\Http\Controllers\Web\CreditController;

Route::get('/products/insufficient_credit', [CreditController::class, 'show'])->name('insufficient.credit');

Route::post('/update-credit', [UsersController::class, 'updateCredit'])->name('update.credit');
Route::post('/update-stock', [ProductsController::class, 'updateStock'])->name('update.stock');

Route::get('/purchases', [UsersController::class, 'purchases'])->name('purchases');

Route::post('/bought-products', [ProductsController::class, 'boughtProducts'])->name('bought_products_list');

Route::get('verify', [UsersController::class, 'verify'])->name('verify');

Route::get(
    '/auth/google',
    [UsersController::class, 'redirectToGoogle']
)->name('login_with_google');

Route::get(
    '/auth/google/callback',
    [UsersController::class, 'handleGoogleCallback']
);


Route::get('forgot-password', [UsersController::class, 'forgotPassword'])->name('forgot_password');
Route::post('send-reset-password', [UsersController::class, 'sendResetPassword'])->name('send_reset_password');
Route::get('change-password', [UsersController::class, 'changePassword'])->name('change-password');
Route::post('update-password', [UsersController::class, 'updatePassword'])->name('update_password');

Route::get('auth/google', [UsersController::class, 'redirectToGoogle'])->name('login_with_google');
Route::get('auth/google/callback', [UsersController::class, 'handleGoogleCallback']);
