<?php

namespace App\Repository;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class AuthRepository {
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login($fields)
    {
        $user = $this->user->where('email', $fields['email'])->first();
        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return null;
        }
        return $user;
    }
    public function register($params)
    {
        $model           = new User();
        $model->name     = $params['name'] ?? '';
        $model->email    = $params['email'] ?? '';
        $model->password = Hash::make($params['password']);
        $model->save();
        return $model;
    }

    public function __forgotPassword($params) {
        try {
            $user = $this->user->where('email', $params['email'])->first();
            if (!$user) {
                return [
                    "code"  => Response::HTTP_BAD_REQUEST,
                    "message" => "Email không tồn tại",
                ];
            }
            $newPassword = Str::random(16);
            $user->password = Hash::make($newPassword);
            $user->save();
            Mail::raw("Mật khẩu mới của bạn là: {$newPassword}", function ($message) use ($user) {
                $message->to($user->email)->subject('Cấp lại mật khẩu mới');
            });

            return [
                "code"    => Response::HTTP_OK,
                "message" => "Mật khẩu mới đã được gửi về email của bạn",
            ];
        } catch (\Exception $e) {
            return [
                "code"    => Response::HTTP_BAD_REQUEST,
                "message" => "Lỗi: " . $e->getMessage(),
            ];
        }
    }
    public function forgotPassword($params) {
        try {
            $user = $this->user->where('email', $params['email'])->first();

            if (!$user) {
                return [
                    "code"    => Response::HTTP_BAD_REQUEST,
                    "message" => "Email không tồn tại",
                ];
            }

            $newPassword = Str::random(16);

            // Gửi mail TRƯỚC khi lưu DB
            // Nếu mail lỗi sẽ throw exception, password chưa bị đổi
            Mail::raw("Mật khẩu mới của bạn là: {$newPassword}", function ($message) use ($user) {
                $message->to($user->email)->subject('Cấp lại mật khẩu mới');
            });

            // Mail gửi thành công → mới cập nhật DB
            $user->password = Hash::make($newPassword);
            $user->save();

            return [
                "code"    => Response::HTTP_OK,
                "message" => "Mật khẩu mới đã được gửi về email của bạn",
            ];
        } catch (\Exception $e) {
            return [
                "code"    => Response::HTTP_BAD_REQUEST,
                "message" => "Lỗi: " . $e->getMessage(),
            ];
        }
    }
    public function findByConditions($params){
        return $this->user->findByConditions($params);
    }

    public function countByConditions($params){
        return $this->user->countByConditions($params);
    }
    
}
