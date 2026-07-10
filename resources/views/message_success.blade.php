<x-modal id="successModal" :footer="false" centered size="md">
    <div class="success-alert">
        <div class="success-alert__source">
            <i class="fa fa-check rounded-circle px-3 py-2 border border-success d-flex align-items-center justify-content-center" aria-hidden="true"></i>            
            <span id="success_message"></span>
        </div>        
        <div class="success-alert__actions">
            <button type="button" class="btn btn-ok" data-bs-dismiss="modal">OK</button>
        </div>
    </div>
</x-modal>