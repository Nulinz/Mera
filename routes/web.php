<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/camera_web', function () {
    return view('camera_web');
    // return 'hello';
});

Route::get('/camera_scan', function () {
    return view('camera_scan');
    // return 'hello';
});
