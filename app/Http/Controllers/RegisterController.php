<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function login()
    {
        return view('dlr.login');
    }

    public function register()
    {
        return view('dlr.register');
    }
}
