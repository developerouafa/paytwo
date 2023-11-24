@extends('Dashboard/layouts.master')
@section('title')
    {{__('Dashboard/permissions.modifythepowers')}}
@endsection
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/permissions.powers')}}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/permissions.modify')}}</span>
            </div>
        </div>
    </div>
@endsection
@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{__('Dashboard/permissions.err')}}</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
        <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mg-b-20">
                        <div class="card-body">
                            <div class="main-content-label mg-b-5">
                                <div class="pull-right">
                                    <a class="btn btn-primary btn-sm" href="{{ route('roles.index') }}">{{__('Dashboard/permissions.back')}}</a>
                                </div>
                            </div>
                            <div class="main-content-label mg-b-5">
                                <div class="form-group">
                                    <p>{{__('Dashboard/permissions.authorityname')}}</p>
                                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="row">
                                <!-- col -->
                                <div class="col-lg-4">
                                    <ul id="treeview1">
                                        <li><a href="#">{{__('Dashboard/permissions.powers')}}</a>
                                            <ul>
                                                <li>
                                                    @foreach($permission as $value)
                                                    <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                                        {{ $value->name }}</label>
                                                    <br />
                                                    @endforeach
                                                </li>

                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-main-primary">{{__('Dashboard/permissions.buttonupdate')}}</button>
                                </div>
                                <!-- /col -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- row closed -->
    {!! Form::close() !!}

@endsection
@section('js')
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
@endsection
