<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

abstract class BaseRequest extends FormRequest
{
    // =========================================================================
    // AUTHORIZATION
    // =========================================================================

    /**
     * Mặc định cho phép tất cả request.
     * Override trong subclass nếu cần kiểm tra quyền riêng.
     */
    public function authorize(): bool
    {
        return true;
    }

    // =========================================================================
    // RULES - Subclass bắt buộc phải override
    // =========================================================================

    abstract public function rules(): array;

    // =========================================================================
    // MESSAGES - Tùy chỉnh thông báo lỗi chung (Tiếng Việt)
    // =========================================================================

    public function messages(): array
    {
        return [
            'required'             => ':attribute không được để trống.',
            'string'               => ':attribute phải là chuỗi ký tự.',
            'integer'              => ':attribute phải là số nguyên.',
            'numeric'              => ':attribute phải là số.',
            'boolean'              => ':attribute phải là true hoặc false.',
            'array'                => ':attribute phải là mảng.',
            'email'                => ':attribute không đúng định dạng email.',
            'min'                  => ':attribute phải có ít nhất :min ký tự.',
            'max'                  => ':attribute không được vượt quá :max ký tự.',
            'min.numeric'          => ':attribute phải lớn hơn hoặc bằng :min.',
            'max.numeric'          => ':attribute không được vượt quá :max.',
            'unique'               => ':attribute đã tồn tại trong hệ thống.',
            'exists'               => ':attribute không tồn tại.',
            'confirmed'            => ':attribute xác nhận không khớp.',
            'in'                   => ':attribute không hợp lệ.',
            'not_in'               => ':attribute không được phép.',
            'date'                 => ':attribute không đúng định dạng ngày.',
            'date_format'          => ':attribute phải theo định dạng :format.',
            'before'               => ':attribute phải trước ngày :date.',
            'after'                => ':attribute phải sau ngày :date.',
            'image'                => ':attribute phải là file hình ảnh.',
            'mimes'                => ':attribute phải có định dạng: :values.',
            'file'                 => ':attribute phải là file hợp lệ.',
            'size'                 => ':attribute phải có kích thước :size KB.',
            'max.file'             => ':attribute không được vượt quá :max KB.',
            'url'                  => ':attribute không đúng định dạng URL.',
            'regex'                => ':attribute không đúng định dạng.',
            'nullable'             => ':attribute có thể để trống.',
            'digits'               => ':attribute phải có đúng :digits chữ số.',
            'digits_between'       => ':attribute phải có từ :min đến :max chữ số.',
            'alpha'                => ':attribute chỉ được chứa chữ cái.',
            'alpha_num'            => ':attribute chỉ được chứa chữ cái và số.',
            'alpha_dash'           => ':attribute chỉ được chứa chữ cái, số, gạch ngang.',
            'between'              => ':attribute phải nằm trong khoảng :min - :max.',
            'json'                 => ':attribute phải là chuỗi JSON hợp lệ.',
            'ip'                   => ':attribute phải là địa chỉ IP hợp lệ.',
            'uuid'                 => ':attribute phải là UUID hợp lệ.',
        ];
    }

    // =========================================================================
    // ATTRIBUTES - Đặt tên tiếng Việt cho các field (override để thêm)
    // =========================================================================

    public function attributes(): array
    {
        return array_merge($this->defaultAttributes(), $this->customAttributes());
    }

    /**
     * Tên chung của các field phổ biến.
     */
    protected function defaultAttributes(): array
    {
        return [
            'id'         => 'ID',
            'name'       => 'Tên',
            'email'      => 'Email',
            'password'   => 'Mật khẩu',
            'phone'      => 'Số điện thoại',
            'address'    => 'Địa chỉ',
            'status'     => 'Trạng thái',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
            'image'      => 'Hình ảnh',
            'file'       => 'File',
            'page'       => 'Trang',
            'per_page'   => 'Số bản ghi mỗi trang',
            'keyword'    => 'Từ khóa tìm kiếm',
            'sort_by'    => 'Trường sắp xếp',
            'sort_order' => 'Thứ tự sắp xếp',
        ];
    }

    /**
     * Subclass override để thêm tên field riêng.
     */
    protected function customAttributes(): array
    {
        return [];
    }

    // =========================================================================
    // XỬ LÝ LỖI VALIDATION - Trả về JSON thống nhất
    // =========================================================================

    protected function failedValidation(Validator $validator): void
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(
                $this->formatErrorResponse($errors),
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }

    /**
     * Format response lỗi. Override để tùy chỉnh cấu trúc.
     */
    protected function formatErrorResponse(array $errors): array
    {
        return [
            'success' => false,
            'message' => 'Dữ liệu không hợp lệ.',
            'errors'  => $errors,
        ];
    }

    // =========================================================================
    // XỬ LÝ LỖI AUTHORIZATION
    // =========================================================================

    protected function failedAuthorization(): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền thực hiện hành động này.',
                'errors'  => [],
            ], JsonResponse::HTTP_FORBIDDEN)
        );
    }

    // =========================================================================
    // HELPERS - Các method tiện ích dùng chung
    // =========================================================================

    /**
     * Lấy tất cả dữ liệu đã validated và merge thêm field tùy chọn.
     */
    public function validatedData(array $extra = []): array
    {
        return array_merge($this->validated(), $extra);
    }

    /**
     * Lấy user đang đăng nhập (shortcut).
     */
    public function currentUser()
    {
        return $this->user();
    }

    /**
     * Lấy ID của user đang đăng nhập.
     */
    public function currentUserId(): ?int
    {
        return $this->user()?->id;
    }

    /**
     * Kiểm tra request có phải từ mobile app không.
     */
    public function isMobileRequest(): bool
    {
        return $this->hasHeader('X-Mobile-App')
            || str_contains($this->userAgent() ?? '', 'Mobile');
    }

    /**
     * Sanitize string: trim + loại bỏ ký tự nguy hiểm.
     */
    protected function sanitizeString(?string $value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Chuẩn bị dữ liệu trước khi validate (sanitize tự động).
     * Override để tùy chỉnh.
     */
    protected function prepareForValidation(): void
    {
        // Tự động trim tất cả string input
        $inputs = $this->all();
        array_walk_recursive($inputs, function (&$value) {
            if (is_string($value)) {
                $value = trim($value);
            }
        });
        $this->replace($inputs);
    }
}