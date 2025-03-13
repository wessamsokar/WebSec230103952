<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


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
// Route::get('/multable/{number?}', function ($number = null) {
//     $j = $number ?? 2;
//     return view('multable', compact('j')); //multable.blade.php
// });

use Illuminate\Http\Request;

// Route::get('/multable', function (Request $request) {
//     $j = $request->number;
//     return view('multable', compact('j')); //multable.blade.php
// });

// Route::get('/multable', function (Request $request) {
//     $j = $request->number;
//     dd($request->all());
//     return view('multable', compact('j')); //multable.blade.php
// });
