<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

trait Helpers
{
    protected $POST = 'POST';
    protected $GET  = 'GET';
    protected $CONTENT_TYPE_JSON =  'application/json';
    protected $CONTENT_TYPE_JS =  'application/javascript';
    protected $CONTENT_MULTI_FORM_DATA = 'multipart/form-data';
    protected $CONTENT_FORM_URLENCODED = 'application/x-www-form-urlencoded';
    public function slug($string)
    {
        $search = [
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
            '#(ì|í|ị|ỉ|ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
            '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
            '#(ỳ|ý|ỵ|ỷ|ỹ)#',
            '#(đ)#',
            '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
            '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
            '#(Ì|Í|Ị|Ỉ|Ĩ)#',
            '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
            '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
            '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
            '#(Đ)#',
            "/[^a-zA-Z0-9\-\_]/",
        ];
        $replace = [
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            'A',
            'E',
            'I',
            'O',
            'U',
            'Y',
            'D',
            '-',
        ];
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        return strtolower($string);
    }

    public function send_mail($params): bool
    {
        try {
            $email = $params['email'] ?? '';
            $name  = $params['name'] ?? '';
            $data  = [
                'email'    => $email,
                'name'     => $name,
                'password' => $params['password'] ?? '',
                'url'      => $params['url'] ?? (config('app.url') . '/login'),
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
            Log::error('Send account info mail failed', [
                'to'    => $email,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
    public function apiBase($url, $method, $postData, $content_type)
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,   // CURLOPT_TIMEOUT => 30 (Image upload may need)
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_POSTFIELDS => $postData,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type:' . $content_type,
                    'Access-Control-Allow-Origin: *',
                    'token:' . session('store.token'),
                ),
                // CURLOPT_SSL_VERIFYPEER => false, // Image upload may need
            ));

            $response = curl_exec($curl);            
            curl_close($curl);
            return $response;
        } catch (\Throwable $th) {            
            return false;            
        }
    }

    public function data_get($url)
    {

        $response = $this->apiBase($url, $this->GET, null, $this->CONTENT_TYPE_JSON);
        return $response;
    }

    public function data_post($url, $postData)
    {
        $response = $this->apiBase($url, $this->POST, $postData, $this->CONTENT_TYPE_JSON);
        return $response;
    }
}
