<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangePasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'current_password'      => ['required', 'string', function ($attribute, $value, $fail) {
                if (!Hash::check($value, auth()->user()->password)) {
                    $fail('Mật khẩu hiện tại không chính xác.');
                }
            }],
            'password'              => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
            'password_confirmation' => ['required', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'current_password'      => 'Mật khẩu hiện tại',
            'password'              => 'Mật khẩu mới',
            'password_confirmation' => 'Xác nhận mật khẩu mới',
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
