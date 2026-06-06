<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function form_login()
    {
        return view('auth.login');
    }

    public function form_register()
    {
        return view('auth.register');
    }
}
