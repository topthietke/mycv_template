<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // Nếu là API request
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn chưa đăng nhập. Vui lòng đăng nhập để tiếp tục.',
                ], 401);
            }

            // Web request: lưu lại URL định đến để sau khi login redirect đúng chỗ
            return redirect()->route('login')
                ->with('warning', 'Bạn cần đăng nhập để truy cập trang này.');
        }

        return $next($request);        
    }
}
