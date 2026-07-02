document.addEventListener('DOMContentLoaded', function () {
    // Click hiển thị form
    // ----------------------------------------------------------------------
    // Map step id -> form id
    const stepFormMap = {
        candidate: 'candidateForm',
        categories: 'categoryForm',
        contents: 'detailsForm',
    };
    const steps = document.querySelectorAll('.step-indicator .step');
    const progressLine = document.getElementById('progress-line');

    // Thứ tự các step để tính % progress line
    const stepOrder = Object.keys(stepFormMap);

    function showForm(stepId) {
        // Ẩn tất cả form
        Object.values(stepFormMap).forEach(formId => {
            const form = document.getElementById(formId);
            if (form) {
                form.classList.remove('active');
                form.style.display = 'none';
            }
        });

        // Hiện form tương ứng với step được click
        const targetFormId = stepFormMap[stepId];
        const targetForm = document.getElementById(targetFormId);
        if (targetForm) {
            targetForm.classList.add('active');
            targetForm.style.display = 'block';
        }
    }

    function setActiveStep(stepId) {
        // Bỏ active tất cả step
        steps.forEach(step => step.classList.remove('active'));

        // Thêm active cho step được chọn
        const currentStep = document.getElementById(stepId);
        if (currentStep) {
            currentStep.classList.add('active');
        }

        // Cập nhật progress line
        const index = stepOrder.indexOf(stepId);
        if (progressLine && index !== -1) {
            const percent = (index / (stepOrder.length - 1)) * 100;
            if (stepId !== 'contents') {
                progressLine.style.width = percent + '%';
            }
        }
    }

    function goToStep(stepId) {
        if (!stepFormMap.hasOwnProperty(stepId)) return;
        setActiveStep(stepId);
        showForm(stepId);
    }

    // Gắn sự kiện click cho từng step
    steps.forEach(step => {
        step.addEventListener('click', function () {
            const stepId = this.id;
            goToStep(stepId);
        });
    });

    // Mặc định hiển thị step đầu tiên (candidate) khi load trang
    goToStep('candidate');
    // ----------------------------------------------------------------------
    
});