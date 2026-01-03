<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/update_popup',function () {
    return response()->json(['version' => '0.0.1']);
});
