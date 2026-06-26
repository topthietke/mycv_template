<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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

    /**
     * Đăng xuất - xoá session + token Sanctum
     */
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
    

    /**
     * Xử lý yêu cầu quên mật khẩu.
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {        

        // Gửi link reset password
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        // Nếu gửi link thất bại (ví dụ: không tìm thấy email)
        // Laravel sẽ tự động ném một ValidationException
        // nhưng để chắc chắn, chúng ta có thể xử lý ở đây.
        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }
}
