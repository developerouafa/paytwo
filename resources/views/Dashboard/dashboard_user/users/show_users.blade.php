@extends('Dashboard/layouts.master')
@section('title')
{{__('Dashboard/users.users')}}
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/users.users')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/users.users')}}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- row opened -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="col-sm-1 col-md-2">
                    {{-- @can('اضافة مستخدم') --}}
                        <a class="btn btn-primary btn-sm" href="{{ route('users.create') }}">{{__('Dashboard/users.addauser')}}</a>
                    {{-- @endcan --}}
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th> {{__('Dashboard/users.name')}} </th>
                                <th> {{__('Dashboard/users.phone')}} </th>
                                <th> {{__('Dashboard/users.email')}} </th>
                                <th> {{__('Dashboard/users.userstatus')}} </th>
                                <th> {{__('Dashboard/users.usertype')}} </th>
                                <th> {{__('Dashboard/users.userolestaus')}} </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->UserStatus == 1)
                                            <span class="label text-success d-flex">
                                                <div class="dot-label bg-success ml-1"></div>
                                            </span>
                                        @else
                                            <span class="label text-danger d-flex">
                                                <div class="dot-label bg-danger ml-1"></div>
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $v)
                                                <label class="badge badge-success">{{ $v }}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->Status == 1)
                                            <span class="label text-success d-flex">
                                                <div class="dot-label bg-success ml-1"></div>
                                            </span>
                                        @else
                                            <span class="label text-danger d-flex">
                                                <div class="dot-label bg-danger ml-1"></div>
                                            </span>
                                        @endif
                                    </td>
                                    {{-- <td>
                                        @if (!empty($user->profileuser->clienType == 1))
                                            <span class="label text-black d-flex">
                                                {{__('Dashboard/users.individual')}}
                                            </span>
                                        @else
                                            <span class="label text-black d-flex">
                                                {{__('Dashboard/users.individual')}}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $user->profileuser->nationalIdNumber }}</td>
                                    <td>{{ $user->profileuser->commercialRegistrationNumber }}</td>
                                    <td>{{ $user->profileuser->taxNumber }}</td>
                                    <td>{{ $user->profileuser->adderss }}</td> --}}
                                    <td>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info"
                                            title="تعديل"><i class="las la-pen"></i></a>
                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                            data-user_id="{{ $user->id }}" data-username="{{ $user->name }}"
                                            data-toggle="modal" href="#modaldemo8" title="حذف"><i
                                                class="las la-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->

    <!-- Modal effects -->
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{__('Dashboard/users.deletetheuser')}}</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('users.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>{{__('Dashboard/users.aresureofthedeleting')}}</p><br>
                        <input type="hidden" name="user_id" id="user_id" value="">
                        <input class="form-control" name="username" id="username" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Dashboard/users.cancel')}}</button>
                        <button type="submit" class="btn btn-danger">{{__('Dashboard/users.save')}}</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>

</div>
<!-- /row -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
<!-- Internal Modal js-->
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>

<script>
    $('#modaldemo8').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var user_id = button.data('user_id')
        var username = button.data('username')
        var modal = $(this)
        modal.find('.modal-body #user_id').val(user_id);
        modal.find('.modal-body #username').val(username);
    })

</script>


@endsection
