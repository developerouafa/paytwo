@extends('Dashboard.layouts.master')
@section('title')
    {{__('Dashboard/main-sidebar_trans.clients')}}
@stop
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
                    <h4 class="content-title mb-0 my-auto">{{__('Dashboard/main-sidebar_trans.clients')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/main-sidebar_trans.view_all')}}</span>
                </div>
            </div>
        </div>
    <!-- breadcrumb -->
@endsection
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
    <!-- row -->
        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add">
                                {{__('Dashboard/clients_trans.add_clients')}}
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap" id="example2">
                                <thead>
                                    <tr>
                                        <th class="wd-15p border-bottom-0">#</th>
                                        <th class="wd-15p border-bottom-0">{{__('Dashboard/clients_trans.phone')}}</th>
                                        <th class="wd-15p border-bottom-0">{{__('Dashboard/clients_trans.status')}}</th>
                                        <th class="wd-20p border-bottom-0">{{__('Dashboard/clients_trans.user_id')}}</th>
                                        <th class="wd-20p border-bottom-0"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clients as $client)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$client->phone}}</td>
                                            <td>
                                                @if ($client->Status == 0)
                                                    <a href="{{route('editstatusdéactive', $client->id)}}" class="dropdown-item"><i class="text-warning ti-back-right"></i>{{__('Dashboard/clients_trans.disabled')}}</a>
                                                @endif
                                                @if ($client->Status == 1)
                                                    <a href="{{route('editstatusactive', $client->id)}}" class="dropdown-item"><i class="text-warning ti-back-right"></i>{{__('Dashboard/clients_trans.active')}}</a>
                                                @endif
                                            </td>
                                            {{-- <td><a href="{{route('Sections.showsection',$client->id)}}">{{$client->user->phone}}</a> </td> --}}
                                            <td><a href="#">{{$client->user->name}}</a> </td>
                                            <td>
                                                <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"  data-toggle="modal" href="#edit{{$client->id}}"><i class="las la-pen"></i></a>
                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"  data-toggle="modal" href="#delete{{$client->id}}"><i class="las la-trash"></i></a>
                                            </td>
                                        </tr>

                                        @include('Dashboard.dashboard_user.clients.edit')
                                        @include('Dashboard.dashboard_user.clients.delete')

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div>
            <!--/div-->

        @include('Dashboard.dashboard_user.clients.create')
        <!-- /row -->

    </div>
    <!-- row closed -->

    <!-- Container closed -->

<!-- main-content closed -->
@endsection
@section('js')


    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>

@endsection
