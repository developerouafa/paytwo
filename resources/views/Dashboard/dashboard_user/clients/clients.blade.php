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
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/main-sidebar_trans.clients')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/main-sidebar_trans.view_all')}}</span>
            </div>
        </div>
    </div>
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
        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            @can('Delete All Clients')
                                <a class="btn btn-danger" href="{{route('Clients.deleteallclients')}}">{{__('Dashboard/messages.Deleteall')}}</a>
                            @endcan

                            @can('Create Client')
                                <a class="btn btn-primary" href="{{route('Clients.createclient')}}">{{__('Dashboard/clients_trans.add_clients')}}</a>
                            @endcan

                            @can('Delete Group Client')
                                <button type="button" class="btn btn-danger" id="btn_delete_all">{{trans('Dashboard/messages.Deletegroup')}}</button>
                            @endcan
                        </div>
                    </div>
                    @can('Show Client')
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-md-nowrap" id="example2" data-page-length="50" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">#</th>
                                            @can('Delete Group Client')
                                                <th><input name="select_all"  id="example-select-all" type="checkbox"/></th>
                                            @endcan
                                            <th class="wd-15p border-bottom-0">{{__('Dashboard/clients_trans.name')}}</th>
                                            <th class="wd-15p border-bottom-0">{{__('Dashboard/users.email')}}</th>
                                            <th class="wd-15p border-bottom-0">{{__('Dashboard/clients_trans.phone')}}</th>
                                            <th class="wd-15p border-bottom-0">{{__('Dashboard/clients_trans.status')}}</th>
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
                                                @can('Delete Group Client')
                                                    <td>
                                                        <input type="checkbox" name="delete_select" value="{{$client->id}}" class="delete_select">
                                                    </td>
                                                @endcan
                                                @can('View Invoices Client')
                                                    <td><a href="{{route('Clients.showinvoice',$client->id)}}">{{$client->name}}</a> </td>
                                                @endcan
                                                @cannot('View Invoices Client')
                                                    <td>{{$client->name}}</td>
                                                @endcannot
                                                <td>{{$client->email}}</td>
                                                <td>{{$client->phone}}</td>
                                                <td>
                                                    @if ($client->Status == 1)
                                                        <a href="{{route('editstatusdéactivecl', $client->id)}}" class="dropdown-item">
                                                            <i class="text-warning ti-back-right"></i>
                                                            {{__('Dashboard/clients_trans.disabled')}}
                                                        </a>
                                                    @endif
                                                    @if ($client->Status == 0)
                                                        <a href="{{route('editstatusactivecl', $client->id)}}" class="dropdown-item">
                                                            <i class="text-warning ti-back-right"></i>
                                                            {{__('Dashboard/clients_trans.active')}}
                                                        </a>
                                                    @endif
                                                </td>
                                                <td><a href="#">{{$client->user->name}}</a> </td>
                                                <td> {{ $client->created_at->diffForHumans() }} </td>
                                                <td> {{ $client->updated_at->diffForHumans() }} </td>
                                                <td>
                                                    <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"  data-toggle="modal" href="#edit{{$client->id}}"><i class="las la-pen"></i></a>
                                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"  data-toggle="modal" href="#delete{{$client->id}}"><i class="las la-trash"></i></a>
                                                </td>
                                            </tr>

                                            @can('Edit Client')
                                                @include('Dashboard.dashboard_user.clients.edit')
                                            @endcan

                                            @can('Delete Client')
                                                @include('Dashboard.dashboard_user.clients.delete')
                                            @endcan

                                            @can('Delete Group Client')
                                                @include('Dashboard.dashboard_user.clients.delete_select')
                                            @endcan

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- bd -->
                    @endcan

                </div><!-- bd -->
            </div>
        </div>
    <!-- row closed -->
@endsection
@section('js')
    <script>
        $(function() {
            jQuery("[name=select_all]").click(function(source) {
                checkboxes = jQuery("[name=delete_select]");
                for(var i in checkboxes){
                    checkboxes[i].checked = source.target.checked;
                }
            });
        })
    </script>

    <script type="text/javascript">
        $(function () {
            $("#btn_delete_all").click(function () {
                var selected = [];
                $("#example input[name=delete_select]:checked").each(function () {
                    selected.push(this.value);
                });

                if (selected.length > 0) {
                    $('#delete_select').modal('show')
                    $('input[id="delete_select_id"]').val(selected);
                }
            });
        });
    </script>

    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>

@endsection
