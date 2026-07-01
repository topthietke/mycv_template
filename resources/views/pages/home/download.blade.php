<div id="dl-bar">
    <button class="btn btn-dark" id="dl-pdf-btn" onclick="downloadPDF()">
        <i class="fa fa-download"></i>
        <span id="btn-text">Tải xuống PDF</span>
        <div id="dl-progress">
            <div id="dl-progress-fill"></div>
        </div>
    </button>
    <a href="{{ route('edit', ['candidate_id' => Auth::user()->id]) }}" class="btn btn-success">
        <i class="fa fa-edit"></i>
        Chỉnh sửa
    </a>
    <a href="/logout" class="btn btn-secondary">
        <i class="fa fa-sign-out" aria-hidden="true"></i>
        Đăng xuất
    </a>
</div>