<?php

namespace App\Http\Requests\Contents;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CategoriesContentsRequest extends BaseRequest
{
    public function rules(): array {        
        return [
            // Bảng categories
            'candidate_id' => ['nullable', 'integer', 'exists:candidates,id'],
            'code'         => ['nullable', 'string', 'max:255'],
            'name'         => ['nullable', 'string', 'max:255'],
            'pages'        => ['nullable', 'string', 'max:100'],

            // Bảng candidate_contents
            'category_id'  => ['nullable', 'integer', 'exists:categories,id'],
            'content'      => ['nullable', 'string'],
        ];
    }

    
    public function attributes(): array
    {
        return [
            'candidate_id' => 'ứng viên',
            'code'         => 'mã danh mục',
            'name'         => 'tên danh mục',
            'pages'        => 'số trang',
            'category_id'  => 'danh mục',
            'content'      => 'nội dung',
        ];
    }

    protected function failedValidation(Validator $validator): void {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
