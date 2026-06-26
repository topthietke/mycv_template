<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Jobs\ResetPasswordJob;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    protected $auth_service;
    public function __construct(AuthService $auth_service) {
        $this->auth_service = $auth_service;
    }

    public function form_login()
    {
        return view('auth.login');
    }

    public function form_register()
    {
        return view('auth.register');
    }

    public function forgot_password()
    {
        return view('auth.forgot_password');
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => ['Email hoặc Mật khẩu không chính xác.'],
            ]);
        }
        $request->session()->regenerate();

        // Tạo Sanctum token và lưu vào session
        $token = Auth::user()->createToken('web-token')->plainTextToken;
        session(['api_token' => $token]);

        return redirect()->intended(route('home'))
            ->with('success', 'Đăng nhập thành công! Chào mừng ' . Auth::user()->name);
    }

    public function logout(Request $request)
    {
        if ($user = Auth::user()) {
            $user->tokens()->delete();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Đã đăng xuất thành công.');
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $password = Str::random(16); // Tạo mật khẩu ngẫu nhiên nếu không có            
            $data = [
                "email" => $request->email,
                "password" => $password
            ];

            $user = $this->auth_service->change_password($data);
            if (!empty($user['code']) && $user['code'] === Response::HTTP_OK) {
                ResetPasswordJob::dispatch($data);
                return redirect()->route('login')->with('success', 'Mật khẩu mới đã được gửi vào email của bạn. Vui lòng kiểm tra hộp thư.');
            } else {
                return redirect()->route('forgot.password')->with('error', $user['message'] ?? 'Có lỗi xảy ra, không thể reset mật khẩu.');
            }
        } catch (\Exception $e) {            
            return [
                "code"      => 403,
                "message"   => $e->getMessage()
            ];
        }
    }
}
