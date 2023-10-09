<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('Dashboard/clients_trans.add_clients')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('Clients.store') }}" method="post" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <label for="phone">{{trans('Dashboard/clients_trans.phone')}}</label>
                    <input type="number" max="10" min="10" class="form-control" value="{{old('phone')}}" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="{{__('Dashboard/clients_trans.phone')}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('Dashboard/clients_trans.Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{trans('Dashboard/clients_trans.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
