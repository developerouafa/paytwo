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
                            @can('Delete All Clients softdelete')
                                <a class="btn btn-danger" href="{{route('Clients.deleteallsoftdelete')}}">{{__('Dashboard/messages.Deleteall')}}</a>
                            @endcan

                            @can('Delete Group Clients softdelete')
                                <button type="button" class="btn btn-danger" id="btn_delete_all">{{trans('Dashboard/messages.Deletegroup')}}</button>
                            @endcan

                            @can('Restore All Clients')
                                <a class="btn btn-info" href="{{route('Clients.restoreallclients')}}">{{__('Dashboard/messages.restoreall')}}</a>
                            @endcan

                            @can('Restore Group Clients')
                                <button type="button" class="btn btn-info" id="btn_restore_all">{{__('Dashboard/messages.RestoreGroup')}}</button>
                            @endcan
                        </div>
                    </div>
                    @can('Show Client softdelete')
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-md-nowrap" id="example2">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">#</th>
                                            @can('Delete Group Clients softdelete')
                                                <th> {{__('Dashboard/messages.Deletegroup')}} <input name="select_all"  id="example-select-all" type="checkbox"/></th>
                                            @endcan
                                            @can('Restore Group Clients')
                                                <th> {{__('Dashboard/messages.RestoreGroup')}} <input name="select_allrestore"  id="example-select-all" type="checkbox"/></th>
                                            @endcan
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
                                                @can('Delete Group Clients softdelete')
                                                    <td>
                                                        <input type="checkbox" name="delete_select" value="{{$client->id}}" class="delete_select">
                                                    </td>
                                                @endcan
                                                @can('Restore Group Clients')
                                                    <td>
                                                        <input type="checkbox" name="restore" value="{{$client->id}}" class="delete_select">
                                                    </td>
                                                @endcan
                                                <td>{{$client->name}}</td>
                                                <td>{{$client->phone}}</td>
                                                <td><a href="#">{{$client->user->name}}</a> </td>
                                                <td> {{ $client->created_at->diffForHumans() }} </td>
                                                <td> {{ $client->updated_at->diffForHumans() }} </td>
                                                <td>
                                                    @can('Restore One Clients')
                                                        <a href="{{route('restorecl', $client->id)}}">{{__('Dashboard/messages.restore')}}</a>
                                                    @endcan
                                                    @can('Delete Clients softdelete')
                                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                            data-id="{{ $client->id }}" data-name="{{ $client->name }}"
                                                            data-toggle="modal" href="#modaldemo9" title="Delete">
                                                            <i class="las la-trash"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- bd -->
                    @endcan
                    @can('Delete Group Clients softdelete')
                        @include('Dashboard.dashboard_user.clients.delete_selectsoftdelete')
                    @endcan
                    @can('Restore Group Clients')
                        @include('Dashboard.dashboard_user.clients.restoreall')
                    @endcan
                </div><!-- bd -->
            </div>
            <!--/div-->
        </div>

        <!-- delete -->
        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">{{__('Dashboard/products.delete')}}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{route('Clients.destroy')}}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>{{__('Dashboard/products.aresuredeleting')}}</p><br>
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" value="3" name="page_id">
                            <input class="form-control" name="name" id="name" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Dashboard/products.Close')}}</button>
                            <button type="submit" class="btn btn-danger">{{__('Dashboard/products.delete')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- /row -->

@endsection
@section('js')
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>

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

    <script>
        $(function() {
            jQuery("[name=select_allrestore]").click(function(source) {
                checkboxes = jQuery("[name=restore]");
                for(var i in checkboxes){
                    checkboxes[i].checked = source.target.checked;
                }
            });
        })
    </script>

    <script type="text/javascript">
        $(function () {
            $("#btn_restore_all").click(function () {
                var selected = [];
                $("#example input[name=restore]:checked").each(function () {
                    selected.push(this.value);
                });

                if (selected.length > 0) {
                    $('#restore').modal('show')
                    $('input[id="restore_select_id"]').val(selected);
                }
            });
        });
    </script>
@endsection
