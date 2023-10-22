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
                    @can('Show Client')
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-md-nowrap" id="example2">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">#</th>
                                            <th class="wd-15p border-bottom-0">{{__('Dashboard/clients_trans.name')}}</th>
                                            <th class="wd-15p border-bottom-0">{{__('Dashboard/clients_trans.phone')}}</th>
                                            <th class="wd-20p border-bottom-0">{{__('Dashboard/users.createdbyuser')}}</th>
                                            <th class="wd-20p border-bottom-0">{{__('Dashboard/sections_trans.created_at')}}</th>
                                            <th class="wd-20p border-bottom-0">{{__('Dashboard/sections_trans.updated_at')}}</th>
                                            <th class="wd-20p border-bottom-0"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clients as $client)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$client->name}}</td>
                                                <td>{{$client->phone}}</td>
                                                {{-- <td><a href="{{route('Sections.showsection',$client->id)}}">{{$client->user->phone}}</a> </td> --}}
                                                <td><a href="#">{{$client->user->name}}</a> </td>
                                                <td> {{ $client->created_at->diffForHumans() }} </td>
                                                <td> {{ $client->updated_at->diffForHumans() }} </td>
                                                <td>
                                                    <a href="{{route('restorecl', $client->id)}}">{{__('Dashboard/messages.restore')}}</a>
                                                    <form action="{{route('forcedeletecl', $client->id)}}" method="get">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">{{__('Dashboard/messages.deletee')}}</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- bd -->
                    @endcan

                </div><!-- bd -->
            </div>
            <!--/div-->

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
