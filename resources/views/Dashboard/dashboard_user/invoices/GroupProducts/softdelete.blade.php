@extends('Dashboard/layouts.master')
@section('title')
    {{__('Dashboard/main-sidebar_trans.deletedGroupServices')}}
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
                <h4 class="content-title mb-0 my-auto">
                    {{__('Dashboard/services.services')}}</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/main-sidebar_trans.deletedGroupServices')}}
                </span>
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
        <div class="row">

            <!-- Index -->
                <div class="col-xl-12">
                    <div class="card mg-b-20">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                @can('Delete All GroupServices softdelete')
                                    <a class="btn btn-danger" href="{{route('GroupServices.deleteall')}}">{{__('Dashboard/messages.Deleteall')}}</a>
                                @endcan

                                @can('Delete Group GroupServices softdelete')
                                    <button type="button" class="btn btn-danger" id="btn_delete_all">{{trans('Dashboard/messages.Deletegroup')}}</button>
                                @endcan

                                @can('Restore All GroupServices')
                                    <a class="btn btn-info" href="{{route('GroupServices.restoreallGroupServices')}}">{{__('Dashboard/messages.restoreall')}}</a>
                                @endcan

                                @can('Restore Group GroupServices')
                                    <button type="button" class="btn btn-info" id="btn_restore_all">{{__('Dashboard/messages.RestoreGroup')}}</button>
                                @endcan

                            </div>
                        </div>
                        @can('Show Group Services softdelete')
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table key-buttons text-md-nowrap" data-page-length="50" style="text-align: center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                @can('Delete Group GroupServices softdelete')
                                                    <th> {{__('Dashboard/messages.Deletegroup')}} <input name="select_all"  id="example-select-all" type="checkbox"/></th>
                                                @endcan
                                                @can('Restore Group GroupServices')
                                                    <th> {{__('Dashboard/messages.RestoreGroup')}} <input name="select_allrestore"  id="example-select-all" type="checkbox"/></th>
                                                @endcan
                                                <th> {{__('Dashboard/services.nameservice')}} </th>
                                                <th>{{__('Dashboard/services.totalofferincludingtax')}}</th>
                                                <th>{{__('Dashboard/services.description')}}</th>
                                                <th>{{__('Dashboard/users.createdbyuser')}}</th>
                                                <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                                                <th>{{__('Dashboard/sections_trans.updated_at')}}</th>
                                                <th>{{__('Dashboard/services.Processes')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($groupservices as $group)
                                                <tr>
                                                    <td>{{ $loop->iteration}}</td>
                                                    @can('Delete Group GroupServices softdelete')
                                                        <td>
                                                            <input type="checkbox" name="delete_select" value="{{$group->id}}" class="delete_select">
                                                        </td>
                                                    @endcan
                                                    @can('Restore Group GroupServices')
                                                        <td>
                                                            <input type="checkbox" name="restore" value="{{$group->id}}" class="delete_select">
                                                        </td>
                                                    @endcan
                                                    <td>
                                                        <a href="{{route('GroupServices.show', $group->id)}}">{{ $group->name }}</a>
                                                    </td>
                                                    <td>{{ number_format($group->Total_with_tax, 2) }}</td>
                                                    <td>{{ \Str::limit($group->notes, 50) }}</td>
                                                    <td>{{$group->user->name}}</td>
                                                    <td> {{ $group->created_at->diffForHumans() }} </td>
                                                    <td> {{ $group->updated_at->diffForHumans() }} </td>
                                                    <td>
                                                        @can('Restore One GroupServices')
                                                            <a href="{{route('GroupServices.restore', $group->id)}}">{{__('Dashboard/messages.restore')}}</a>
                                                        @endcan
                                                        @can('Delete GroupServices One softdelete')
                                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                                data-id="{{ $group->id }}" data-name="{{ $group->invoice_number }}"
                                                                data-toggle="modal" href="#modaldemo9" title="Delete">
                                                                <i class="las la-trash"></i>
                                                            </a>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                    </table>
                                </div>
                            </div>
                        @endcan
                        @can('Delete Group GroupServices softdelete')
                            @include('Dashboard.dashboard_user.invoices.GroupProducts.delete_selectsoftdelete')
                        @endcan
                    </div>
                </div>

            <!-- delete -->
                <div class="modal" id="modaldemo9">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">{{__('Dashboard/products.delete')}}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                    type="button"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <form action="{{route('GroupServices.destroy')}}" method="post">
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
        </div>
	<!-- row closed -->
@endsection
@section('js')
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
        })
    </script>

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
@endsection
