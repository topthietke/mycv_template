<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController {
    use AuthorizesRequests, ValidatesRequests;

    public function responseData($data, $code = null, $message = null)
    {
        return response()->json([
            'code' => $code ?? '200',
            'message' => $message ?? 'Success',
            'data' => $data ?? null,
            'version' => '2025.08'
        ]);
    }


    public function test_send_mail(Request $request): bool {        
        $toEmail = $request->input('toEmail');
        $toName = $request->input('toName');
        $subject = $request->input('subject');
        $content = $request->input('content');
        $attachments = $request->input('attachments', []);

        try {
            Mail::send(
                'templates.email_template',
                [
                    'candidateName' => $toName,
                    'subject'       => $subject,
                    'content'       => $content,
                ],
                function ($message) use ($toEmail, $toName, $subject, $attachments) {
                    $message->to($toEmail, $toName)->subject($subject);

                    foreach ($attachments as $filePath) {
                        if (file_exists($filePath)) {
                            $message->attach($filePath);
                        }
                    }
                }
            );

            return true;
        } catch (\Exception $e) {            
            Log::error('Send mail failed', [
                'to'      => $toEmail,
                'subject' => $subject,
                'error'   => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function send_account_info_mail(Request $request): bool { 
        try {
            $name  = $request->input('name');
            $email = $request->input('email');
            $data  = [
                'email'    => $email,
                'name'     => $name,
                'password' => $request->input('password'),
                'url'      => config('app.url') . '/login',
            ];
            
            Mail::send(
                'templates.thong_tin_tai_khoan',
                $data,
                function ($message) use ($email, $name) {
                    $message
                        ->to($email, $name)
                        ->subject('Thông tin tài khoản đăng nhập của bạn');
                }
            );
            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Send account info mail failed', [
                'to'    => $data['email'],
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
