<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',            
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Vui lòng nhập email của bạn',
            'email.email' => 'Email của bạn không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu của bạn',
            'password.min' => 'Độ dài mật khẩu phải lớn hơn 8',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors  ]));
    }
}
