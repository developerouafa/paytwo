<!-- Modal -->
<div class="modal fade" id="delete{{ $fund_account->receiptaccount->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> {{__('Dashboard/receipt_trans.Deletereceipt')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('Receipt.destroy', 'test') }}" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
            <div class="modal-body">
                <input type="hidden" name="id" value="{{ $fund_account->receiptaccount->id }}">
                <input type="hidden" value="1" name="page_id">
                <h5>{{trans('Dashboard/sections_trans.Warning')}}<span style="color: red"> {{ $fund_account->receiptaccount->clients->name }}</span></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('Dashboard/receipt_trans.Close')}}</button>
                <button type="submit" class="btn btn-danger">{{trans('Dashboard/messages.deletee')}}</button>
            </div>
            </form>
        </div>
    </div>
</div>
