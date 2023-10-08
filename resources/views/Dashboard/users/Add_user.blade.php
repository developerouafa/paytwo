@extends('Dashboard/layouts.master')
@section('title')
{{__('Dashboard/users.addauser')}}
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
            <h4 class="content-title mb-0 my-auto">{{__('Dashboard/users.users')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{__('Dashboard/users.addauser')}}
                </span>
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
                <strong>{{__('Dashboard/users.err')}}</strong>
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
                        <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}">{{__('Dashboard/users.back')}}</a>
                    </div>
                </div><br>
                <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                    action="{{route('users.store','test')}}" method="post">
                    {{csrf_field()}}

                    <div class="">
                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>{{__('Dashboard/users.nameen')}} <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper" name="nameen" required type="text" autofocus>
                            </div>

                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>{{__('Dashboard/users.namear')}} <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper" name="namear" required type="text" autofocus>
                            </div>
                        </div>
                        {{-- <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>{{__('Dashboard/users.phone')}} <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper" name="phone" required type="text" autofocus>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{__('Dashboard/users.clienType')}}</label>
                                <select name="clienType" id="select-beast" class="form-control  nice-select  custom-select">
                                    <option value="1">{{__('Dashboard/users.individual')}}</option>
                                    <option value="0">{{__('Dashboard/users.company')}}</option>
                                </select>
                            </div>
                        </div> --}}
                    </div>

                    {{-- <div class="">
                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>{{__('Dashboard/users.nationalIdNumber')}}</label>
                                <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper" name="nationalIdNumber" type="text" autofocus>
                            </div>

                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>{{__('Dashboard/users.commercialRegistrationNumber')}}</label>
                                <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper" name="commercialRegistrationNumber" type="text" autofocus>
                            </div>
                        </div>
                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>{{__('Dashboard/users.taxNumber')}}</label>
                                <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper" name="taxNumber" type="text" autofocus>
                            </div>

                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>{{__('Dashboard/users.adderss')}}</label>
                                <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper" name="adderss" type="text" autofocus>
                            </div>
                        </div>
                    </div> --}}

                    <div class="">
                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>{{__('Dashboard/users.email')}}<span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper" name="email" required type="email">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{__('Dashboard/users.userolestaus')}}</label>
                                <select name="Status" id="select-beast" class="form-control  nice-select  custom-select">
                                    <option value="1">{{__('Dashboard/users.active')}}</option>
                                    <option value="0">{{__('Dashboard/users.noactive')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>{{__('Dashboard/users.password')}}<span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                    name="password" required type="password">
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>{{__('Dashboard/users.confirmpassword')}}<span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                    name="confirm-password" required type="password">
                            </div>
                        </div>
                    </div>

                    <div class="row mg-b-20">
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label"> {{__('Dashboard/users.uservalidity')}}<span class="tx-danger">*</span></label>
                                {!! Form::select('roles_name[]', $roles,[], array('class' => 'form-control','multiple','required')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button class="btn btn-main-primary pd-x-20" type="submit">{{__('Dashboard/users.save')}}</button>
                    </div>
                </form>
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
