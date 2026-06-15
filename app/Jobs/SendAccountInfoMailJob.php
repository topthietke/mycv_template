<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendAccountInfoMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3; // số lần retry nếu thất bại

    public function __construct(public array $data) {}

    public function handle(): void
    {
        Mail::send(
            'templates.thong_tin_tai_khoan',
            $this->data,
            function ($message) {
                $message
                    ->to($this->data['email'], $this->data['name'])
                    ->subject('Thông tin tài khoản đăng nhập của bạn');
            }
        );
    }

    // Được gọi khi job thất bại sau khi hết số lần retry
    public function failed(Throwable $exception): void
    {
        Log::error('Send account info mail failed', [
            'to'    => $this->data['email'] ?? '',
            'error' => $exception->getMessage(),
        ]);
    }
}
