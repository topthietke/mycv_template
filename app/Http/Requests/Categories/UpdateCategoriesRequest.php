<?php

namespace App\Http\Requests\Categories;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class UpdateCategoriesRequest extends BaseRequest
{
    public function rules(): array
    {        
        $categoryId = $this->route('category'); 
        return [
            'code' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'code')->ignore($categoryId),
            ],
            'name'         => ['required', 'string', 'max:255'],
            'candidate_id' => ['nullable', 'integer'],            
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'code'         => 'Mã danh mục',
            'name'         => 'Tên danh mục',
            'candidate_id' => 'ID ứng viên'            
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