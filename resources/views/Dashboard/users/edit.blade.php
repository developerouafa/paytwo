@extends('layouts.master')
@section('title')
{{__('message.modifyauser')}}
@endsection
@section('css')
<!-- Internal Nice-select css  -->
<link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{__('message.users')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                {{__('message.modifyauser')}}</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-lg-12 col-md-12">

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{__('message.err')}}</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}">{{__('message.back')}}</a>
                    </div>
                </div><br>

                {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
                    <div class="">
                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>{{__('message.First Name')}}  <span class="tx-danger">*</span></label>
                                <input value="{{$user->profileuser->firstname}}" class="form-control" required name="firstname_{{app()->getLocale()}}" id="firstname" type="text"  autocomplete="off" >
                            </div>
                            <input type="hidden" name="idprofile" value="{{$user->profileuser->id}}">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>{{__('message.last Name')}}  <span class="tx-danger">*</span></label>
                                <input value="{{$user->profileuser->lastname}}" class="form-control" required name="lastname_{{app()->getLocale()}}" id="lastname" type="text"  autocomplete="off" >
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>{{__('message.Email')}} <span class="tx-danger">*</span></label>
                                {!! Form::text('email', $user->email, array('class' => 'form-control','required')) !!}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{__('message.userolestaus')}}</label>
                                <select name="Status" id="select-beast" class="form-control  nice-select  custom-select">
                                    <option value="{{ $user->Status}}">
                                        @if ($user->Status == 1)
                                            {{__('message.active')}}
                                        @else
                                            {{__('message.noactive')}}
                                        @endif
                                    </option>
                                    <option value="1">{{__('message.active')}}</option>
                                    <option value="0">{{__('message.noactive')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label>{{__('message.Password')}} <span class="tx-danger">*</span></label>
                            {!! Form::password('password', array('class' => 'form-control')) !!}
                        </div>

                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label>{{__('message.currentpassword')}} <span class="tx-danger">*</span></label>
                            {!! Form::password('confirm-password', array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="row mg-b-20">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('message.usertype')}}</strong>
                                {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple'))
                                !!}
                            </div>
                        </div>
                    </div>
                    <div class="mg-t-30">
                        <button class="btn btn-main-primary pd-x-20" type="submit">{{__('message.buttonupdate')}}</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>




</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')

<!-- Internal Nice-select js-->
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

<!--Internal  Parsley.min js -->
<script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
<!-- Internal Form-validation js -->
<script src="{{URL::asset('assets/js/form-validation.js')}}"></script>
@endsection
