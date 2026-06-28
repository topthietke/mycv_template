<?php

namespace App\Http\Requests\Categories;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreMultipleCategoriesRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'candidate_id' => ['required', 'integer', 'exists:candidates,id'],
            'name'         => ['required', 'array', 'min:1'],
            'name.*'       => [
                'required',
                'string',
                'max:255',
                // Kiểm tra code (slug) generate từ name.* không được trùng trong DB
                function ($attribute, $value, $fail) {
                    $code = Str::slug($value, '-');
                    $exists = DB::table('categories')->where('candidate_id', $this->candidate_id)->where('code', $code)->exists();
                    if ($exists) {
                        $fail("Tên " . $value . " đã tồn tại.");
                    }
                },
            ],
        ];
    }


    /**
     * Chuẩn bị data sau khi validate — inject thêm `code` cho từng name
     */
    public function validated($key = null, $default = null): array
    {
        $data = parent::validated($key, $default);

        $data['items'] = collect($data['name'])->map(fn($name) => [
            'name'         => $name,
            'code'         => Str::slug($name, '-'),
            'candidate_id' => $data['candidate_id'],
        ])->toArray();

        return $data;
    }

     public function attributes(): array {
        return [
            'name'         => 'Tên danh mục',
            'code'         => 'Vị trí ứng tuyển',
            'candidate_id' => 'Ngày sinh',
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