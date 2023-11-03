<!-- Modal -->
<div class="modal fade" id="edit{{ $invoice->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('Dashboard/clients_trans.modifypymethod')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('Invoices.modifypymethod') }}" method="post">
                @csrf
                <div class="modal-body">
                    <label for="name">{{trans('Dashboard/services.invoicenumber')}}</label>
                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                    <input type="text" disabled name="name_{{app()->getLocale()}}" value="{{ $invoice->invoice_number }}" class="form-control" id="name">
                </div>
                <div class="modal-body">
                    <select name="type" class="form-control" required>
                        <option value="" selected disabled>{{__('Dashboard/login_trans.Choose_list')}}</option>
                        <option value="1"> {{__('Dashboard/services.monetary')}} </option>
                        <option value="2"> {{__('Dashboard/services.Okay')}} </option>
                        <option value="3"> {{__('Dashboard/services.Banktransfer')}} </option>
                        <option value="4"> {{__('Dashboard/services.card')}} </option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('Dashboard/sections_trans.Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{trans('Dashboard/sections_trans.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
