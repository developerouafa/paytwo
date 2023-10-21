<!-- Modal -->
<div class="modal fade" id="edit{{ $client->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('Dashboard/clients_trans.edit_client')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('Clients.update', 'test') }}" method="post">
                {{ method_field('patch') }}
                {{ csrf_field() }}
                @csrf
                <div class="modal-body">
                    <label for="inputName1" class="control-label">{{__('Dashboard/clients_trans.name')}}<span class="tx-danger">*</span></label>
                    <input placeholder="{{__('Dashboard/clients_trans.name')}}" value="{{ $client->name }}" class="form-control @error('description') is-invalid @enderror" name="name" id="name" type="text">
                </div>
                <div class="modal-body">
                    <label for="phone">{{trans('Dashboard/clients_trans.phone')}}</label>
                    <input type="hidden" name="id" value="{{ $client->id }}">
                    <input type="number" name="phone" value="{{ $client->phone }}" class="form-control" id="phone">
                </div>


                <div class="modal-body">
                    <label>{{__('Dashboard/users.password')}} <span class="tx-danger">*</span></label>
                    {!! Form::password('password', array('class' => 'form-control')) !!}
                </div>

                <div class="modal-body">
                    <label>{{__('Dashboard/users.currentpassword')}} <span class="tx-danger">*</span></label>
                    {!! Form::password('confirm-password', array('class' => 'form-control')) !!}
                </div>



                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('Dashboard/clients_trans.Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{trans('Dashboard/clients_trans.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
