<!-- Modal -->
<div wire:ignore.self class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('Dashboard/services.Deleteinvoicedata')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{__('Dashboard/services.surdelete')}} 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> {{__('Dashboard/services.close')}} </button>
                <button type="button" wire:click.prevent="destroy()" class="btn btn-danger"> {{__('Dashboard/services.delete')}} </button>
            </div>

        </div>
    </div>
</div>
