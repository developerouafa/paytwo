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
                    <label for="inputName1" class="control-label">{{__('Dashboard/clients_trans.name')}}<span class="tx-danger">*</span></label>
                    <input type="text" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                </div>

                <div class="modal-body">
                    <label for="phone">{{trans('Dashboard/clients_trans.phone')}}</label>
                    <input type="number" class="form-control" value="{{old('phone')}}" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="{{__('Dashboard/clients_trans.phone')}}">
                </div>

                <div class="modal-body">
                    <label>{{__('Dashboard/users.password')}}<span class="tx-danger">*</span></label>
                    <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper" name="password" required type="password">
                </div>

                <div class="modal-body">
                    <label>{{__('Dashboard/users.confirmpassword')}}<span class="tx-danger">*</span></label>
                    <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper" name="confirm-password" required type="password">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('Dashboard/clients_trans.Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{trans('Dashboard/clients_trans.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
