<?php

namespace App\Http\Requests\Categories;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCategoryRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'code'          => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'code')->where('candidate_id', $this->candidate_id)
            ],
            'name'          => 'required|string|max:255',
            'candidate_id'  => 'nullable|integer|exists:candidates,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'code'         => 'Mã danh mục',
            'name'         => 'Tên danh mục',
            'candidate_id' => 'Ứng viên',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
