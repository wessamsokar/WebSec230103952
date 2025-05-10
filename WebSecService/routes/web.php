<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\StudentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Models\User;
use App\Http\Controllers\Web\CreditController;
use App\Http\Controllers\Web\FileEncryptionController;

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

    $email = emailFromLoginCertificate();
    if ($email && !auth()->user()) {
        $user = User::where('email', $email)->first();
        if ($user)
            Auth::login($user);
    }

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

// Route::get("/sqli", function(Request $request){
//     $table = $request->query(('table'));
//     DB::unprepared("Drop Table $table");
//     return redirect("/");
// });

// Route::get('/collect', function (Request $request) {
//     $name = $request->query('name');
//     $credits = $request->query('credits');

//     return response(['data collected',200])
//         ->headers('Access-Control-Allow-Origin', '*')
//         ->header('Access-Control-Allow-Credentials', 'true')
//         ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
//         ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With');
// });

Route::get('/cryptography', function (Request $request) {

    $data = $request->data ?? "Welcome to Cryptography";
    $action = $request->action ?? "Encrypt";
    $result = $request->result ?? "";
    $status = "Failed";
    $size = 0;

    if ($request->action == "Encrypt") {

        $temp = openssl_encrypt($request->data, 'aes-128-ecb', 'thisisasecretkey', OPENSSL_RAW_DATA, '');
        if ($temp) {
            $status = 'Encrypted Successfully';
            $result = base64_encode($temp);
        }
    } else if ($request->action == "Decrypt") {

        $temp = base64_decode($request->data);

        $result = openssl_decrypt($temp, 'aes-128-ecb', 'thisisasecretkey', OPENSSL_RAW_DATA, '');

        if ($result)
            $status = 'Decrypted Successfully';
    } else if ($request->action == "Hash") {

        $temp = hash('sha256', $request->data);

        $result = base64_encode($temp);

        $status = 'Hashed Successfully';
    } else if ($request->action == "Sign") {

        $path = storage_path('app/private/useremail@domain.com.pfx');
        $password = '12345678';
        $certificates = [];

        $pfx = file_get_contents($path);
        openssl_pkcs12_read($pfx, $certificates, $password);
        $privateKey = $certificates['pkey'];

        $signature = '';
        if (openssl_sign($request->data, $signature, $privateKey, 'sha256')) {
            $result = base64_encode($signature);
            $status = 'Signed Successfully';
        }
    } else if ($request->action == "Verify") {

        $signature = base64_decode($request->result);

        $path = storage_path('app/public/useremail@domain.com.crt');
        $publicKey = file_get_contents($path);

        if (openssl_verify($request->data, $signature, $publicKey, 'sha256')) {
            $status = 'Verified Successfully';
        }
    } else if ($request->action == "KeySend") {

        $path = storage_path('app/public/useremail@domain.com.crt');
        $publicKey = file_get_contents($path);
        $temp = '';

        if (openssl_public_encrypt($request->data, $temp, $publicKey)) {
            $result = base64_encode($temp);
            $status = 'Key is Encrypted Successfully';
        }
    } else if ($request->action == "KeyRecive") {

        $path = storage_path('app/private/useremail@domain.com.pfx');
        $password = '12345678';
        $certificates = [];

        $pfx = file_get_contents($path);
        openssl_pkcs12_read($pfx, $certificates, $password);
        $privateKey = $certificates['pkey'];

        $encryptedKey = base64_decode($request->data);
        $result = '';

        if (openssl_private_decrypt($encryptedKey, $result, $privateKey)) {

            $status = 'Key is Decrypted Successfully';
        }
    }
    return view('cryptography', compact('data', 'result', 'action', 'status'));
})->name('cryptography');

Route::get('/webcrypto', function () {
    return view('webcrypto');
})->name('webcrypto');

Route::view('/file-security', 'file-security')->name('file.security');
Route::post('/encrypt', [FileEncryptionController::class, 'encryptFile'])->name('encrypt.file');
Route::post('/decrypt', [FileEncryptionController::class, 'decryptFile'])->name('decrypt.file');
