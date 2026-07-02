<?php

namespace App\Http\Requests\Candidate;

use App\Http\Requests\BaseRequest;
use App\Models\Candidate;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateCandidateRequest extends BaseRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'fullname'               => 'required|string|max:255',
            'position'               => 'required|string|max:255',
            'birthday'               => 'required|date',
            'gender'                 => 'required|string',
            'email'                  => [
                'required',
                'email',
                Rule::unique('candidates')->ignore($this->route('candidate')),
            ],
            'phone'                  => 'required|string|max:20',
            'identity_card'          => 'required|string|max:50',
            'identity_date'          => 'required|date',
            'identity_place'         => 'required|string',
            'home_town'              => 'required|string',
            'current_address'        => 'required|string',
            'expected_salary'        => 'nullable|numeric',
            'avatar'                 => 'nullable|image|mimes:jpeg,png,jpg|max:2048',                 
        ];
    }

    protected function customAttributes(): array {
        return [
            'fullname'               => 'Họ và tên',
            'position'               => 'Vị trí ứng tuyển',
            'birthday'               => 'Ngày sinh',
            'gender'                 => 'Giới tính',
            'email'                  => 'Địa chỉ email',
            'phone'                  => 'Số điện thoại',
            'identity_card'          => 'Số CMND/CCCD',
            'identity_date'          => 'Ngày cấp CMND/CCCD',
            'identity_place'         => 'Nơi cấp CMND/CCCD',
            'home_town'              => 'Quê quán',
            'current_address'        => 'Địa chỉ hiện tại',
            'expected_salary'        => 'Mức lương mong muốn',
            'avatar'                 => 'Ảnh đại diện',            
        ];
    }
}
