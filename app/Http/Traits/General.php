<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

trait General {
    function sendmail($data, $view)
    {
        try {
            Log::error("Hệ thống đã gửi mail tới: " . $data['to']);
            Mail::send($view, $data, function ($message) use ($data) {
                $message->to($data['to'])->subject($data['subject']);
            });
            return response()->json([
                "code" => 200,
                "message" => "Gửi mail đăng ký thành công"
            ]);
        } catch (\Exception $e) {
            Log::error("Thông báo lỗi gửi mail: " . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => "Gửi mail đăng ký thất bại"
            ]);
        }
    }

    public function send_account_info_mail($data): bool {        
        try {
            $name     = $data['name'];
            $email    = $data['email'];
            $password = $data['password'];
            $status   = $data['status'];
            Mail::send(        
                'templates.thong_tin_tai_khoan',
                [
                    'name'     => $name,
                    'email'    => $email,
                    'password' => $password,
                    'status'   => $status
                ],
                function ($message) use ($email, $name) {
                        $message
                        ->to($email, $name)
                        ->subject('Thông tin tài khoản đăng nhập của bạn');
                }
            );

            return true;
        } catch (\Exception $e) {     
            // dd($e->getMessage()); // Removed debugging statement
            Log::error('Send account info mail failed', [
                'to'    => $email,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
