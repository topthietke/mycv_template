<!-- FAB (dấu +, hình 2) -->
<div class="fab-wrap">
    <button class="btn btn-outline-success rounded-circle px-3 py-2" id="fabBtn" aria-expanded="false"
        aria-controls="quickActions">+</button>
</div>

<!-- Quick Actions Panel (hình 1) -->
<div class="quick-actions" id="quickActions">
    <div class="qa-header">
        <h6 class="fw-bold">Danh mục</h6>
        <button id="qaClose">
            <i class="fa fa-times fa-xs text-danger"></i>
        </button>
    </div>
    <div class="qa-item" onclick="downloadPDF()">
        <div class="icon-box">
            <i class="fa fa-download"></i>
        </div>
        {{-- Tải file PDF --}}
        {{-- ------------------------------------------------------------ --}}
        <div>
            <div class="qa-title">
                Tải file PDF
            </div>
            <div class="qa-sub text-muted">
                Bấm vào đây để tải xuống
            </div>
        </div>
        {{-- ------------------------------------------------------------ --}}
    </div>
    <a href="{{ route('edit', ['candidate_id' => Auth::user()->id]) }}" class="text-dark text-decoration-none">
        <div class="qa-item">
            <div class="icon-box">
                <i class="fa fa-edit"></i>
            </div>
            <div>
                <div class="qa-title">                    
                    Chỉnh sửa thông tin
                </div>
                <div class="qa-sub text-muted">
                    Bấm vào đây để chỉnh sửa thông tin
                </div>
            </div>
        </div>
    </a>
    <a href="/logout" class="text-dark text-decoration-none">
        <div class="qa-item">
            <div class="icon-box">
                <i class="fa fa-sign-out" aria-hidden="true"></i>
            </div>
            <div>
                <div class="qa-title">
                    <a href="/logout" class="text-dark text-decoration-none">
                        Đăng xuất
                    </a>
                </div>
                <div class="qa-sub text-muted">
                    Chọn để đăng xuất hệ thống
                </div>
            </div>
        </div>
    </a>
    <div class="qa-item">

    </div>
</div>

<!-- Backdrop -->
<div class="backdrop" id="backdrop"></div>


<style>
    .fab-wrap {
        position: absolute;
        right: 2%;
        top: 5%;
        transform: translate(-50%, -50%);
        width: 56px;
        height: 56px;
        z-index: 5;
    }

    /* --- Quick Actions Panel --- */
    .quick-actions {
        position: absolute;
        right: 0;
        top: 18%;
        transform: translate(-50%, -42%) scale(.85);
        width: 82%;
        max-width: 300px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 18px 50px rgba(0, 0, 0, .45);
        opacity: 0;
        pointer-events: none;
        transition: opacity .22s ease, transform .22s ease;
        z-index: 10;
    }

    .quick-actions.show {
        opacity: 1;
        pointer-events: auto;
        transform: translate(-50%, -50%) scale(1);
    }


    .qa-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 18px 8px 18px;
    }

    .qa-header span {
        font-size: 12px;
        letter-spacing: .06em;
        font-weight: 700;
        color: var(--text-muted);
    }

    .qa-header button {
        border: none;
        background: transparent;
        color: #8a8a8e;
        font-size: 20px;
        line-height: 1;
        padding: 0;
    }

    .qa-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 18px;
        cursor: pointer;
        transition: background .15s ease;
        border-top: 1px solid #f0f0f2;
    }

    .qa-item:hover {
        background: #f7f7f8;
    }

    .qa-item .icon-box {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f2f2f4;
        color: var(--text-dark);
        flex-shrink: 0;
    }

    .qa-item.active .icon-box {
        background: var(--accent);
        color: #fff;
    }

    .qa-item .qa-title {
        font-weight: 600;
        font-size: 15px;
        color: var(--text-dark);
    }

    .qa-item.active .qa-title {
        color: var(--accent);
    }

    .qa-item .qa-sub {
        font-size: 12px;
        color: var(--text-muted);
    }


    .backdrop {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, .35);
        opacity: 0;
        pointer-events: none;
        transition: opacity .22s ease;
        z-index: 8;
    }

    .backdrop.show {
        opacity: 1;
        pointer-events: auto;
    }

    .footer-strip {
        background: #1c1c1e;
        padding: 10px 16px 16px 16px;
        color: #8a8a8e;
        font-size: 12px;
    }

    .footer-strip .author {
        color: #fff;
        font-weight: 600;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

