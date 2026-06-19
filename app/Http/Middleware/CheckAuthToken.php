<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckAuthToken {
    
    protected string $cookieName = 'auth_token';

    public function handle(Request $request, Closure $next)
    {
        $token = $request->cookie($this->cookieName);
        if (!$token) {
            return $this->unauthorized($request);
        }
    
        $response = Http::withToken($token)
            ->acceptJson()
            ->timeout(5)
            ->get(config('services.mycv_api.url', 'http://api.mycv.local/api') . '/me');

        if ($response->failed()) {
            return $this->unauthorized($request);
        }

        // Gắn thông tin user vào request để Controller/View dùng tiếp nếu cần
        $request->attributes->set('auth_user', $response->json());
        $request->attributes->set('auth_token', $token);

        return $next($request);
    }

    protected function unauthorized(Request $request)
    {
        // Xoá cookie token không hợp lệ (nếu có)
        cookie()->queue(cookie()->forget($this->cookieName));

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return redirect()->route('auth.login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
    }
}