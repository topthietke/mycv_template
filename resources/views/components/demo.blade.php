{{--
    ============================================================
    DEMO: Sử dụng tất cả Blade Components
    ============================================================
--}}

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Bootstrap Components Demo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light py-4">
<div class="container">

    {{-- ======================================= --}}
    {{-- 1. INPUT COMPONENT                       --}}
    {{-- ======================================= --}}
    <x-card title="1. Input Component" class="mb-4">

        {{-- Basic input --}}
        <x-input name="fullname" label="Họ và tên" placeholder="Nhập họ và tên" required />

        {{-- Input with hint --}}
        <x-input
            name="email"
            type="email"
            label="Email"
            placeholder="example@email.com"
            hint="Chúng tôi sẽ không chia sẻ email của bạn."
        />

        {{-- Input with prefix/suffix (addon) --}}
        <x-input
            name="price"
            type="number"
            label="Giá bán"
            placeholder="0"
            prefix="₫"
            suffix=".000"
        />

        {{-- Input with icon suffix --}}
        <x-input
            name="website"
            label="Website"
            placeholder="yoursite.com"
            prefix="https://"
        />

        {{-- Disabled + Readonly --}}
        <div class="row">
            <div class="col-md-6">
                <x-input name="code" label="Mã hệ thống" value="USR-00123" readonly />
            </div>
            <div class="col-md-6">
                <x-input name="locked" label="Trường bị khóa" value="Không thể sửa" disabled />
            </div>
        </div>

        {{-- Sizes --}}
        <div class="row align-items-end">
            <div class="col">
                <x-input name="sm_input" label="Small" placeholder="Size sm" size="sm" />
            </div>
            <div class="col">
                <x-input name="md_input" label="Default" placeholder="Size default" />
            </div>
            <div class="col">
                <x-input name="lg_input" label="Large" placeholder="Size lg" size="lg" />
            </div>
        </div>

        {{-- Input with error (simulate) --}}
        <x-input
            name="phone"
            label="Số điện thoại"
            placeholder="0912345678"
            error="Số điện thoại không hợp lệ."
        />

    </x-card>

    {{-- ======================================= --}}
    {{-- 2. TEXTAREA COMPONENT                   --}}
    {{-- ======================================= --}}
    <x-card title="2. Textarea Component" class="mb-4">

        <x-textarea
            name="bio"
            label="Giới thiệu bản thân"
            placeholder="Viết vài dòng về bạn..."
            rows="3"
            hint="Tối đa 500 ký tự."
        />

        <x-textarea
            name="description"
            label="Mô tả (có đếm ký tự)"
            placeholder="Nhập mô tả..."
            rows="4"
            maxlength="200"
        />

        <x-textarea
            name="note_err"
            label="Ghi chú (có lỗi)"
            rows="2"
            error="Trường này là bắt buộc."
        />

    </x-card>

    {{-- ======================================= --}}
    {{-- 3. SELECT COMPONENT                     --}}
    {{-- ======================================= --}}
    <x-card title="3. Select Component" class="mb-4">

        {{-- Basic select --}}
        <x-select
            name="province"
            label="Tỉnh / Thành phố"
            :options="[
                'hn'  => 'Hà Nội',
                'hcm' => 'TP. Hồ Chí Minh',
                'dn'  => 'Đà Nẵng',
                'hp'  => 'Hải Phòng',
            ]"
            placeholder="-- Chọn tỉnh thành --"
            required
        />

        {{-- Select với value được chọn sẵn --}}
        <x-select
            name="status"
            label="Trạng thái"
            selected="active"
            :options="[
                'active'   => 'Hoạt động',
                'inactive' => 'Tạm dừng',
                'banned'   => 'Bị khóa',
            ]"
        />

        {{-- Select with error --}}
        <x-select
            name="role"
            label="Vai trò"
            :options="['admin' => 'Quản trị viên', 'user' => 'Người dùng']"
            error="Vui lòng chọn vai trò."
        />

        {{-- Multiple select --}}
        <x-select
            name="skills"
            label="Kỹ năng (nhiều lựa chọn)"
            :multiple="true"
            :selected="['php', 'vue']"
            :options="[
                'php'   => 'PHP / Laravel',
                'js'    => 'JavaScript',
                'vue'   => 'Vue.js',
                'react' => 'React',
                'mysql' => 'MySQL',
            ]"
            hint="Giữ Ctrl để chọn nhiều."
        />

        {{-- Sizes --}}
        <div class="row">
            <div class="col-md-6">
                <x-select name="sel_sm" label="Select Small" size="sm"
                    :options="['a'=>'Option A','b'=>'Option B']" />
            </div>
            <div class="col-md-6">
                <x-select name="sel_lg" label="Select Large" size="lg"
                    :options="['a'=>'Option A','b'=>'Option B']" />
            </div>
        </div>

    </x-card>

    {{-- ======================================= --}}
    {{-- 4. BUTTON COMPONENT                     --}}
    {{-- ======================================= --}}
    <x-card title="4. Button Component" class="mb-4">

        {{-- Variants --}}
        <h6 class="text-muted mb-3">Variants</h6>
        <div class="d-flex flex-wrap gap-2 mb-4">
            <x-button variant="primary">Primary</x-button>
            <x-button variant="secondary">Secondary</x-button>
            <x-button variant="success">Success</x-button>
            <x-button variant="danger">Danger</x-button>
            <x-button variant="warning">Warning</x-button>
            <x-button variant="info">Info</x-button>
            <x-button variant="dark">Dark</x-button>
            <x-button variant="light">Light</x-button>
            <x-button variant="link">Link</x-button>
        </div>

        {{-- Outline --}}
        <h6 class="text-muted mb-3">Outline Variants</h6>
        <div class="d-flex flex-wrap gap-2 mb-4">
            <x-button variant="outline-primary">Primary</x-button>
            <x-button variant="outline-secondary">Secondary</x-button>
            <x-button variant="outline-success">Success</x-button>
            <x-button variant="outline-danger">Danger</x-button>
            <x-button variant="outline-warning">Warning</x-button>
            <x-button variant="outline-info">Info</x-button>
        </div>

        {{-- With Icons --}}
        <h6 class="text-muted mb-3">Với Icons (Bootstrap Icons)</h6>
        <div class="d-flex flex-wrap gap-2 mb-4">
            <x-button variant="primary" icon="bi bi-save">Lưu</x-button>
            <x-button variant="success" icon="bi bi-plus-circle">Thêm mới</x-button>
            <x-button variant="danger" icon="bi bi-trash">Xóa</x-button>
            <x-button variant="warning" icon="bi bi-pencil">Chỉnh sửa</x-button>
            <x-button variant="info" icon-end="bi bi-arrow-right">Tiếp tục</x-button>
            <x-button variant="secondary" icon="bi bi-download">Tải xuống</x-button>
        </div>

        {{-- Sizes --}}
        <h6 class="text-muted mb-3">Sizes</h6>
        <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
            <x-button variant="primary" size="sm">Small</x-button>
            <x-button variant="primary">Default</x-button>
            <x-button variant="primary" size="lg">Large</x-button>
        </div>

        {{-- States --}}
        <h6 class="text-muted mb-3">States</h6>
        <div class="d-flex flex-wrap gap-2 mb-4">
            <x-button variant="primary" :loading="true">Loading</x-button>
            <x-button variant="secondary" :disabled="true">Disabled</x-button>
        </div>

        {{-- Submit button --}}
        <h6 class="text-muted mb-3">Submit / Types</h6>
        <div class="d-flex flex-wrap gap-2 mb-4">
            <x-button type="submit" variant="primary" icon="bi bi-send">Gửi form</x-button>
            <x-button type="reset" variant="outline-secondary">Đặt lại</x-button>
            <x-button variant="primary" href="#" icon="bi bi-box-arrow-up-right">Anchor Button</x-button>
        </div>

        {{-- Block button --}}
        <h6 class="text-muted mb-3">Block (full width)</h6>
        <x-button variant="primary" :block="true" icon="bi bi-box-arrow-in-right">Đăng nhập</x-button>

    </x-card>

    {{-- ======================================= --}}
    {{-- 5. CHECKBOX & RADIO                     --}}
    {{-- ======================================= --}}
    <x-card title="5. Checkbox & Radio Component" class="mb-4">

        <div class="row">
            <div class="col-md-6">
                <h6 class="text-muted mb-3">Checkbox</h6>
                <x-checkbox name="agree" label="Tôi đồng ý với điều khoản" :checked="true" />
                <x-checkbox name="newsletter" label="Đăng ký nhận bản tin" />
                <x-checkbox name="disabled_cb" label="Đã bị vô hiệu hóa" :disabled="true" :checked="true" />
                <x-checkbox name="switch_mode" label="Chế độ tối" :switch="true" />
                <x-checkbox name="switch_on" label="Thông báo (Switch On)" :switch="true" :checked="true" />

                <hr>
                <h6 class="text-muted mb-2">Inline Checkbox</h6>
                <x-checkbox name="opt1" label="Option 1" :inline="true" value="1" />
                <x-checkbox name="opt2" label="Option 2" :inline="true" value="2" />
                <x-checkbox name="opt3" label="Option 3" :inline="true" value="3" />
            </div>

            <div class="col-md-6">
                <h6 class="text-muted mb-3">Radio</h6>
                <x-radio name="gender" label="Nam" value="male" :checked="true" />
                <x-radio name="gender" label="Nữ" value="female" />
                <x-radio name="gender" label="Khác" value="other" />
                <x-radio name="gender_dis" label="Bị vô hiệu hóa" value="dis" :disabled="true" />

                <hr>
                <h6 class="text-muted mb-2">Inline Radio</h6>
                <x-radio name="size_r" label="S" value="s" :inline="true" :checked="true" />
                <x-radio name="size_r" label="M" value="m" :inline="true" />
                <x-radio name="size_r" label="L" value="l" :inline="true" />
                <x-radio name="size_r" label="XL" value="xl" :inline="true" />
            </div>
        </div>

    </x-card>

    {{-- ======================================= --}}
    {{-- 6. FILE INPUT                           --}}
    {{-- ======================================= --}}
    <x-card title="6. File Input Component" class="mb-4">

        <x-file
            name="avatar"
            label="Ảnh đại diện"
            accept="image/*"
            :preview="true"
            hint="Chấp nhận: JPG, PNG, WEBP. Tối đa 2MB."
        />

        <x-file
            name="documents"
            label="Tài liệu đính kèm (nhiều file)"
            accept=".pdf,.docx,.xlsx"
            :multiple="true"
            hint="Chấp nhận: PDF, Word, Excel."
        />

    </x-card>

    {{-- ======================================= --}}
    {{-- 7. ALERT COMPONENT                      --}}
    {{-- ======================================= --}}
    <x-card title="7. Alert Component" class="mb-4">

        <x-alert type="success">Lưu thông tin thành công!</x-alert>
        <x-alert type="danger">Có lỗi xảy ra, vui lòng thử lại.</x-alert>
        <x-alert type="warning">Phiên đăng nhập sẽ hết hạn sau 5 phút.</x-alert>
        <x-alert type="info">Hệ thống sẽ bảo trì vào lúc 23:00 tối nay.</x-alert>

        {{-- With title --}}
        <x-alert type="success" title="Thành công!">
            Hồ sơ của bạn đã được cập nhật và đang chờ xét duyệt.
        </x-alert>

        {{-- Dismissible --}}
        <x-alert type="warning" title="Cảnh báo" :dismissible="true">
            Bạn chưa xác thực địa chỉ email. Vui lòng kiểm tra hộp thư.
        </x-alert>

    </x-card>

    {{-- ======================================= --}}
    {{-- 8. FULL FORM EXAMPLE                    --}}
    {{-- ======================================= --}}
    <x-card title="8. Ví dụ Form Hoàn Chỉnh" shadow class="mb-4">
        <form action="#" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <x-input name="f_name" label="Họ" placeholder="Nguyễn" required />
                </div>
                <div class="col-md-6">
                    <x-input name="l_name" label="Tên" placeholder="Văn An" required />
                </div>
            </div>

            <x-input name="f_email" type="email" label="Email" placeholder="user@example.com"
                prefix="✉" required hint="Dùng để đăng nhập vào hệ thống." />

            <x-input name="f_password" type="password" label="Mật khẩu" required
                hint="Tối thiểu 8 ký tự, bao gồm chữ hoa và số." />

            <x-select name="f_role" label="Vai trò" required
                :options="['admin'=>'Quản trị viên','manager'=>'Quản lý','staff'=>'Nhân viên']" />

            <x-textarea name="f_note" label="Ghi chú" rows="3" placeholder="Nhập ghi chú..." maxlength="300" />

            <x-checkbox name="f_active" label="Tài khoản hoạt động" :checked="true" :switch="true" />
            <x-checkbox name="f_agree" label="Tôi đồng ý với điều khoản sử dụng" required />

            <hr>
            <div class="d-flex justify-content-end gap-2">
                <x-button type="reset" variant="outline-secondary" icon="bi bi-arrow-counterclockwise">
                    Đặt lại
                </x-button>
                <x-button type="submit" variant="primary" icon="bi bi-save">
                    Lưu thông tin
                </x-button>
            </div>
        </form>
    </x-card>

    {{-- ======================================= --}}
    {{-- 9. MODAL COMPONENT                      --}}
    {{-- ======================================= --}}
    <x-card title="9. Modal Component" class="mb-4">
        <div class="d-flex gap-2">
            <x-button variant="primary" data-bs-toggle="modal" data-bs-target="#demoModal">
                Mở Modal Cơ Bản
            </x-button>
            <x-button variant="danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                Modal Xác nhận Xóa
            </x-button>
            <x-button variant="info" data-bs-toggle="modal" data-bs-target="#formModal">
                Modal Chứa Form
            </x-button>
        </div>
    </x-card>

</div>

{{-- Modal definitions --}}

<x-modal id="demoModal" title="Thông tin chi tiết" size="lg" :centered="true"
    close-label="Đóng" submit-label="Xác nhận" submit-variant="primary">
    <p>Đây là nội dung của modal. Bạn có thể đặt bất kỳ nội dung nào vào đây.</p>
    <p class="mb-0">Modal hỗ trợ các kích thước: <code>sm</code>, <code>lg</code>, <code>xl</code>.</p>
</x-modal>

<x-modal id="deleteModal" title="Xác nhận xóa" :centered="true" :static="true"
    close-label="Hủy" submit-label="Xóa ngay" submit-variant="danger">
    <x-alert type="danger">
        Bạn có chắc chắn muốn xóa mục này không? Hành động này <strong>không thể hoàn tác</strong>.
    </x-alert>
</x-modal>

<x-modal id="formModal" title="Thêm người dùng" size="lg"
    submit-label="Lưu" form-id="addUserForm">
    <form id="addUserForm" action="#" method="POST">
        @csrf
        <x-input name="m_name" label="Họ tên" placeholder="Nhập họ tên" required />
        <x-input name="m_email" type="email" label="Email" placeholder="user@example.com" required />
        <x-select name="m_role" label="Vai trò"
            :options="['admin'=>'Quản trị viên','user'=>'Người dùng']" />
    </form>
</x-modal>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
