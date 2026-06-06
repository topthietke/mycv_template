# Laravel Bootstrap Blade Components

Bộ Blade Components sử dụng Bootstrap 5, tối ưu cho dự án Laravel.

---

## 📁 Cấu trúc thư mục

```
resources/views/components/
├── input/index.blade.php
├── textarea/index.blade.php
├── select/index.blade.php
├── button/index.blade.php
├── checkbox/index.blade.php
├── radio/index.blade.php
├── file/index.blade.php
├── alert/index.blade.php
├── card/index.blade.php
└── modal/index.blade.php
```

---

## 🔧 Cài đặt

Sao chép các file vào `resources/views/components/`.
Đảm bảo đã include Bootstrap 5 CSS + JS và Bootstrap Icons trong layout:

```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
...
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
```

---

## 📖 Hướng dẫn sử dụng

### `<x-input>` — Text Input

| Prop          | Type    | Default   | Mô tả                          |
|---------------|---------|-----------|-------------------------------|
| `name`        | string  | `''`      | Tên field (bắt buộc)          |
| `label`       | string  | `null`    | Label hiển thị                |
| `type`        | string  | `'text'`  | Loại input (text, email, ...) |
| `placeholder` | string  | `''`      | Placeholder text              |
| `value`       | string  | `''`      | Giá trị mặc định              |
| `required`    | bool    | `false`   | Bắt buộc (hiện dấu *)        |
| `disabled`    | bool    | `false`   | Vô hiệu hóa                  |
| `readonly`    | bool    | `false`   | Chỉ đọc                       |
| `hint`        | string  | `null`    | Text gợi ý bên dưới           |
| `prefix`      | string  | `null`    | Input group prefix            |
| `suffix`      | string  | `null`    | Input group suffix            |
| `size`        | string  | `null`    | `sm` hoặc `lg`                |
| `error`       | string  | `null`    | Thông báo lỗi thủ công        |

```blade
{{-- Basic --}}
<x-input name="email" type="email" label="Email" required />

{{-- Với addon --}}
<x-input name="price" label="Giá" prefix="₫" suffix=".000" />

{{-- Với lỗi tùy chỉnh --}}
<x-input name="phone" label="SĐT" error="Số điện thoại không hợp lệ" />

{{-- Tự động lấy lỗi từ $errors (validation) --}}
<x-input name="email" label="Email" />
```

---

### `<x-textarea>` — Textarea

| Prop         | Type   | Default | Mô tả                    |
|--------------|--------|---------|--------------------------|
| `name`       | string | `''`    | Tên field                |
| `label`      | string | `null`  | Label                    |
| `rows`       | int    | `4`     | Số dòng hiển thị         |
| `maxlength`  | int    | `null`  | Giới hạn ký tự + counter|
| `resize`     | bool   | `true`  | Cho phép kéo resize      |

```blade
<x-textarea name="bio" label="Giới thiệu" rows="5" maxlength="500" />
```

---

### `<x-select>` — Select / Dropdown

| Prop          | Type   | Default     | Mô tả                         |
|---------------|--------|-------------|-------------------------------|
| `options`     | array  | `[]`        | `['value' => 'label']`        |
| `selected`    | mixed  | `null`      | Giá trị được chọn sẵn         |
| `placeholder` | string | `'Chọn...'` | Option placeholder đầu tiên   |
| `multiple`    | bool   | `false`     | Cho chọn nhiều                |

```blade
{{-- Basic --}}
<x-select name="status" label="Trạng thái"
    :options="['active' => 'Hoạt động', 'inactive' => 'Tạm dừng']"
    selected="active"
/>

{{-- Multiple --}}
<x-select name="tags" label="Tags" :multiple="true"
    :options="['php' => 'PHP', 'js' => 'JavaScript']"
    :selected="['php', 'js']"
/>

{{-- OptGroup (truyền thủ công qua slot) --}}
<x-select name="city" label="Thành phố">
    <optgroup label="Miền Bắc">
        <option value="hn">Hà Nội</option>
        <option value="hp">Hải Phòng</option>
    </optgroup>
    <optgroup label="Miền Nam">
        <option value="hcm">TP. HCM</option>
    </optgroup>
</x-select>
```

---

### `<x-button>` — Button

| Prop          | Type   | Default     | Mô tả                          |
|---------------|--------|-------------|--------------------------------|
| `variant`     | string | `'primary'` | Bootstrap color variant        |
| `type`        | string | `'button'`  | `button`, `submit`, `reset`    |
| `size`        | string | `null`      | `sm` hoặc `lg`                 |
| `disabled`    | bool   | `false`     | Vô hiệu hóa                   |
| `loading`     | bool   | `false`     | Hiện spinner + text "Đang xử lý" |
| `icon`        | string | `null`      | Bootstrap Icons class (trước)  |
| `iconEnd`     | string | `null`      | Bootstrap Icons class (sau)    |
| `block`       | bool   | `false`     | Full width (`w-100`)           |
| `href`        | string | `null`      | Render thành thẻ `<a>`         |

```blade
<x-button variant="primary" type="submit" icon="bi bi-save">Lưu</x-button>
<x-button variant="danger" icon="bi bi-trash" size="sm">Xóa</x-button>
<x-button variant="primary" :loading="$isProcessing">Gửi</x-button>
<x-button variant="primary" href="{{ route('home') }}">Về trang chủ</x-button>
```

---

### `<x-checkbox>` — Checkbox

| Prop       | Type   | Default | Mô tả                    |
|------------|--------|---------|--------------------------|
| `value`    | string | `'1'`   | Giá trị khi checked      |
| `checked`  | bool   | `false` | Trạng thái mặc định      |
| `switch`   | bool   | `false` | Hiển thị dạng toggle     |
| `inline`   | bool   | `false` | Hiển thị ngang hàng      |

```blade
<x-checkbox name="agree" label="Tôi đồng ý" required />
<x-checkbox name="dark_mode" label="Chế độ tối" :switch="true" :checked="true" />
```

---

### `<x-radio>` — Radio Button

```blade
<x-radio name="gender" label="Nam"  value="male"   :checked="true" />
<x-radio name="gender" label="Nữ"   value="female" />
<x-radio name="gender" label="Khác" value="other"  :inline="true" />
```

---

### `<x-file>` — File Input

| Prop       | Type   | Default | Mô tả                           |
|------------|--------|---------|---------------------------------|
| `accept`   | string | `null`  | MIME types / extensions         |
| `multiple` | bool   | `false` | Cho upload nhiều file           |
| `preview`  | bool   | `false` | Hiển thị preview ảnh sau chọn  |

```blade
<x-file name="avatar" label="Ảnh đại diện" accept="image/*" :preview="true" />
<x-file name="docs" label="Tài liệu" accept=".pdf,.docx" :multiple="true" />
```

---

### `<x-alert>` — Alert

| Prop          | Type   | Default | Mô tả                  |
|---------------|--------|---------|------------------------|
| `type`        | string | `info`  | Bootstrap color        |
| `title`       | string | `null`  | Tiêu đề alert          |
| `dismissible` | bool   | `false` | Có nút đóng hay không  |

```blade
<x-alert type="success">Lưu thành công!</x-alert>
<x-alert type="danger" title="Lỗi!" :dismissible="true">
    Không thể kết nối đến máy chủ.
</x-alert>
```

---

### `<x-card>` — Card

| Prop       | Type   | Default | Mô tả                  |
|------------|--------|---------|------------------------|
| `title`    | string | `null`  | Tiêu đề card header    |
| `subtitle` | string | `null`  | Phụ đề nhỏ             |
| `shadow`   | bool   | `false` | Thêm box-shadow        |
| `border`   | string | `null`  | CSS class border       |
| `flush`    | bool   | `false` | Bỏ padding card-body   |

```blade
<x-card title="Thông tin cá nhân" shadow>
    Nội dung card...
</x-card>

{{-- Card với actions header --}}
<x-card title="Danh sách">
    <x-slot name="actions">
        <x-button variant="primary" size="sm" icon="bi bi-plus">Thêm</x-button>
    </x-slot>
    Nội dung...
</x-card>
```

---

### `<x-modal>` — Modal

| Prop            | Type   | Default     | Mô tả                       |
|-----------------|--------|-------------|------------------------------|
| `id`            | string | `'modal'`   | ID của modal (bắt buộc)     |
| `title`         | string |             | Tiêu đề                     |
| `size`          | string | `null`      | `sm`, `lg`, `xl`            |
| `centered`      | bool   | `false`     | Căn giữa màn hình            |
| `scrollable`    | bool   | `false`     | Nội dung cuộn bên trong      |
| `static`        | bool   | `false`     | Không đóng khi click ngoài  |
| `submitLabel`   | string | `null`      | Label nút submit             |
| `submitVariant` | string | `'primary'` | Variant nút submit           |
| `formId`        | string | `null`      | ID form để submit từ modal   |

```blade
{{-- Trigger --}}
<x-button data-bs-toggle="modal" data-bs-target="#myModal">Mở Modal</x-button>

{{-- Modal --}}
<x-modal id="myModal" title="Xác nhận" :centered="true"
    submit-label="Đồng ý" submit-variant="danger" :static="true">
    Bạn có chắc chắn muốn thực hiện thao tác này?
</x-modal>
```

---

## ✅ Tích hợp với Laravel Validation

Tất cả components **tự động** đọc lỗi từ `$errors` (MessageBag của Laravel):

```php
// Controller
public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email|unique:users',
        'name'  => 'required|min:3',
    ]);
}
```

```blade
{{-- View - tự động hiện lỗi nếu validate fail --}}
<x-input name="email" label="Email" required />
<x-input name="name"  label="Tên"   required />
```

---

## 💡 Tips

- Dùng `old()` được tích hợp sẵn — giá trị sẽ giữ lại sau khi validation fail.
- Tất cả components đều hỗ trợ truyền thêm attributes HTML tùy ý qua `$attributes`.
- Prop `error` cho phép truyền thông báo lỗi thủ công, ghi đè `$errors`.
