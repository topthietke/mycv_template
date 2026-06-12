<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;


class LoginController extends Controller {
    //
    protected $user_interface;
    public function __construct(AuthService $user_interface){
        $this->user_interface = $user_interface;
    }

    public function form_login() {
        return view('auth.login');
    }

    public function login(LoginRequest $request) {
        $params = $request->all();
        return $this->user_interface->login($params);
    }

    public function form_register() {
        return view('auth.register');
    } 

    public function register(RegisterRequest $request) {
        $params = $request -> all();        
        return $this->user_interface->register($params);
    }

    
    public function logout() {
        return $this->user_interface->logout();
    }
    public function forgotPassword(Request $request) {
        $params = $request->all();        
        return $this->user_interface->forgotPassword($params);
    }
    public function change_password(ChangePasswordRequest $request) {
        $params = $request->all();
        return $this->user_interface->change_password($params);
    }
}
