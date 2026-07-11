// ------------------------------------------------------------------------------------------------------------
// Download CV
async function downloadPDF() {
    // Lấy các phần tử UI và kiểm tra sự tồn tại của chúng
    const ui = {
        btn: document.getElementById('dl-pdf-btn'),
        btnText: document.getElementById('btn-text'),
        progressBar: document.getElementById('dl-progress'),
        progressFill: document.getElementById('dl-progress-fill'),
        dlBar: document.getElementById('dl-bar')
    };

    // Hàm cập nhật giao diện, chỉ chạy nếu phần tử tồn tại
    const updateUI = (updates) => {
        if (ui.btn) ui.btn.disabled = updates.disabled;
        if (ui.btnText) ui.btnText.textContent = updates.text;
        if (ui.progressBar) ui.progressBar.style.display = updates.progressVisible ? 'block' : 'none';
        if (ui.progressFill) ui.progressFill.style.width = updates.progressValue + '%';
        if (ui.dlBar) ui.dlBar.style.display = updates.dlBarVisible ? 'flex' : 'none';
    };

    // Trạng thái ban đầu khi bắt đầu tải
    updateUI({
        disabled: true,
        text: 'Đang chuẩn bị…',
        progressVisible: true,
        progressValue: 10,
        dlBarVisible: false
    });

    try {
        await generateAndSavePDF(progress => {
            updateUI({
                disabled: true,
                text: progress.message,
                progressVisible: true,
                progressValue: progress.percentage,
                dlBarVisible: false
            });
        });

        updateUI({
            disabled: true,
            text: 'Hoàn tất!',
            progressVisible: true,
            progressValue: 100
        });
        await new Promise(r => setTimeout(r, 800));

    } catch (err) {
        console.error('Lỗi khi tạo PDF:', err);
        updateUI({
            disabled: false,
            text: 'Có lỗi, thử lại',
            progressVisible: false,
            progressValue: 0
        });
    } finally {
        // Khôi phục UI về trạng thái ban đầu
        setTimeout(() => {
            updateUI({
                disabled: false,
                text: 'Tải xuống PDF',
                progressVisible: false,
                progressValue: 0,
                dlBarVisible: true
            });
        }, 1500);
    }
}

async function generateAndSavePDF(onProgress) {
    const { jsPDF } = window.jspdf;
    const A4_W = 210;
    const A4_H = 297;

    const pdf = new jsPDF({
        orientation: 'portrait',
        unit: 'mm',
        format: 'a4',
        compress: true,
    });

    const pages = Array.from(document.querySelectorAll('.cv-page')).filter(Boolean);
    if (pages.length === 0) {
        throw new Error('Không tìm thấy trang CV nào có class ".cv-page"');
    }

    for (let i = 0; i < pages.length; i++) {
        const page = pages[i];
        const percentage = 10 + ((i + 1) / pages.length) * 75;
        onProgress({
            percentage: Math.round(percentage),
            message: `Đang render trang ${i + 1}/${pages.length}…`
        });

        // Patch overflow để tránh cắt mất bullet points
        const listElements = page.querySelectorAll('ul, ol');
        listElements.forEach(el => el.style.overflow = 'visible');

        const canvas = await html2canvas(page, {
            scale: 2,
            useCORS: true,
            allowTaint: true,
            backgroundColor: '#ffffff',
            logging: false,
        });

        // Khôi phục lại style
        listElements.forEach(el => el.style.overflow = '');

        const imgData = canvas.toDataURL('image/jpeg', 0.95);
        const imgH = (canvas.height / canvas.width) * A4_W;

        if (i > 0) pdf.addPage();
        pdf.addImage(imgData, 'JPEG', 0, 0, A4_W, Math.min(imgH, A4_H));
    }

    onProgress({
        percentage: 95,
        message: 'Đang tạo file PDF…'
    });
    await new Promise(r => setTimeout(r, 200));

    pdf.save('Trần Ngọc Tú - PHP Developer.pdf');
}

document.addEventListener('DOMContentLoaded', function () {
    const fabBtn = document.getElementById('fabBtn');
    const quickActions = document.getElementById('quickActions');
    const backdrop = document.getElementById('backdrop');
    const qaClose = document.getElementById('qaClose');

    function toggleQuickActions() {
        const isOpen = quickActions.classList.toggle('show');
        backdrop.classList.toggle('show', isOpen);
        fabBtn.classList.toggle('open', isOpen);
        fabBtn.setAttribute('aria-expanded', isOpen);
    }

    function closeQuickActions() {
        quickActions.classList.remove('show');
        backdrop.classList.remove('show');
        fabBtn.classList.remove('open');
        fabBtn.setAttribute('aria-expanded', 'false');
    }

    // Click vào dấu + -> hiện/ẩn panel (toggle)
    fabBtn.addEventListener('click', toggleQuickActions);

    // Click nút đóng (x) hoặc click ra ngoài (backdrop) -> ẩn panel
    qaClose.addEventListener('click', closeQuickActions);
    backdrop.addEventListener('click', closeQuickActions);
});