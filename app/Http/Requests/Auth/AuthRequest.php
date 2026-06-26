<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class AuthRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'email'    => 'required',
            'password' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'email.required'    => 'Vui lòng nhập email của bạn',
            'email.email'       => 'Email của bạn không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khẩu của bạn',
            'password.min'      => 'Độ dài mật khẩu phải lớn hơn 8',
        ];
    }
    public function attributes(): array
    {
        return [
            'email'  => 'Địa chỉ email',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ.',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
