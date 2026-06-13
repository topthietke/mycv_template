<?php

namespace App\Services\Auth;

use App\Http\Traits\General;
use App\Repository\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AuthService
{
     use General;
     protected $user_repository;

     public function __construct(AuthRepository $user_repository)
     {
          $this->user_repository = $user_repository;
     }

     public function login($params)
     {
          // Check email
          $user = $this->user_repository->login($params);
          if (!empty($user)) {
               $token = $user->createToken('auth_token')->plainTextToken;  // Trường hợp báo lỗi hàm này thì phải có HasApiTokens trong model  User   
               return [
                    "code"    => Response::HTTP_OK,
                    "message" => "Đăng nhập thành công",
                    "data"    => $user,
                    'token'   => $token
               ];
          } else {
               return [
                    "code"    => Response::HTTP_BAD_REQUEST,
                    "message" => "Email hoặc Mật khẩu không đúng",                    
               ];
          }
     }
     public function register($params)
     {
          if (empty($params['password'])) {
               $params['password'] = Str::random(16); // Tạo mật khẩu ngẫu nhiên nếu không có
          }


          $user = $this->user_repository->register($params);
          if (!empty($user['id'])) {
               $token = $user->createToken('auth_token')->plainTextToken;
               // Gửi mail thông báo mật khẩu
               $this->send_account_info_mail([
                    'toEmail' => $user->email,
                    'toName'  => $user->name,
                    'password' => $params['password']
               ]);
               $data = [
                    "code"    => Response::HTTP_OK,
                    "message" => "Đăng ký thành công",
                    "data"    => [
                         'user'  => $user,
                         'token' => $token
                    ]
               ];
          } else {
               $data = [
                    "code"  => Response::HTTP_BAD_REQUEST,
                    "message" => !empty($user['message']) ? $user['message'] : "Đăng ký thất bại",
               ];
          }

          return $data;
     }
     public function logout()
     {
          if (auth()->check()) {
               auth()->user()->currentAccessToken()->delete();
               return [
                    "code"    => Response::HTTP_OK,
                    "message" => "Đăng xuất thành công",
               ];
          }
          return [
               "code"    => Response::HTTP_UNAUTHORIZED,
               "message" => "Bạn chưa đăng nhập",
          ];
     }
     public function forgotPassword($params)
     {
          return $this->user_repository->forgotPassword($params);
     }
     public function change_password($params)
     {
          try {
               $user = Auth::user();               
               $user->update([
                    'password' => Hash::make($params['password']),
               ]);

               return [
                    "code"    => Response::HTTP_OK,
                    "success" => true,
                    "message" => "Đổi mật khẩu thành công.",
               ];
          } catch (\Exception $e) {
               return [
                    "code"    => Response::HTTP_INTERNAL_SERVER_ERROR,
                    "success" => false,
                    "message" => "Đã xảy ra lỗi, vui lòng thử lại sau.",
               ];
          }
     }
}
