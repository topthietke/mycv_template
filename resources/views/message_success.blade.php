<x-modal id="successModal" :footer="false" centered size="md">
    <div class="success-alert">
        <div class="success-alert__source">
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            <span id="success_message"></span>
        </div>        
        <div class="success-alert__actions">
            <button type="button" class="btn btn-ok" data-bs-dismiss="modal">OK</button>
        </div>
    </div>
</x-modal>