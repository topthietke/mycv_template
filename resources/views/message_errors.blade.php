<x-modal id="errorsModal" :footer="false" centered size="md">
    <div class="errors-alert">
        <div class="errors-alert__source">
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            <span id="errors_message"></span>
        </div>        
        <div class="errors-alert__actions">
            <button type="button" class="btn btn-ok" data-bs-dismiss="modal">OK</button>
        </div>
    </div>
</x-modal>