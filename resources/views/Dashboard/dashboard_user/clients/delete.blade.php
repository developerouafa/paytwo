<!-- Modal -->
<div class="modal fade" id="delete{{ $client->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('Dashboard/clients_trans.delete_client')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('Clients.destroy', 'test') }}" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
            <div class="modal-body">
                <input type="hidden" value="1" name="page_id">
                <input type="hidden" name="id" value="{{ $client->id }}">
                <h5>{{trans('Dashboard/clients_trans.Warning')}}</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('Dashboard/sections_trans.Close')}}</button>
                <button type="submit" class="btn btn-danger">{{trans('Dashboard/sections_trans.submit')}}</button>
            </div>
            </form>
        </div>
    </div>
</div>
