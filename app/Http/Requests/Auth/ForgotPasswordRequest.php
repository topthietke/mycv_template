<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class ForgotPasswordRequest extends BaseRequest
{
    public function rules(): array
    {        
        return [
            'email' => 'required|email',
        ];
    }

    public function attributes(): array {
        return [
            'email'  => 'Địa chỉ email',
        ];
    }

    protected function failedValidation(Validator $validator): void {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ.',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
