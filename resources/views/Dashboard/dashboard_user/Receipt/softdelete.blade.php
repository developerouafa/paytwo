@extends('Dashboard.layouts.master')
@section('title')
    {{__('Dashboard/main-sidebar_trans.deletedreceipt')}}
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('Dashboard/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('dashboard/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/receipt_trans.theaccounts')}}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/main-sidebar_trans.deletedreceipt')}} </span>
            </div>
        </div>
    </div>
@endsection
@section('content')

    <!-- row -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            @can('Delete All Receipt softdelete')
                                <a class="btn btn-danger" href="{{route('Receipt.deleteallsoftdeleterc')}}">{{__('Dashboard/messages.Deleteall')}}</a>
                            @endcan

                            @can('Delete Group Receipt softdelete')
                                <button type="button" class="btn btn-danger" id="btn_delete_all">{{trans('Dashboard/messages.Deletegroup')}}</button>
                            @endcan

                            @can('Restore All Receipt')
                                <a class="btn btn-info" href="{{route('Receipt.restoreallReceiptAccount')}}">{{__('Dashboard/messages.restoreall')}}</a>
                            @endcan

                            @can('Restore Group Receipt')
                                <button type="button" class="btn btn-info" id="btn_restore_all">{{__('Dashboard/messages.RestoreGroup')}}</button>
                            @endcan
                        </div>
                    </div>
                    @can('Show Receipt')
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table key-buttons text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            @can('Delete Group Receipt softdelete')
                                                <th> {{__('Dashboard/messages.Deletegroup')}} <input name="select_all"  id="example-select-all" type="checkbox"/></th>
                                            @endcan
                                            @can('Restore Group Receipt')
                                                <th> {{__('Dashboard/messages.RestoreGroup')}} <input name="select_allrestore"  id="example-select-all" type="checkbox"/></th>
                                            @endcan
                                            <th> {{__('Dashboard/receipt_trans.nameclient')}} </th>
                                            <th> {{__('Dashboard/receipt_trans.price')}} </th>
                                            <th> {{__('Dashboard/receipt_trans.descr')}} </th>
                                            <th>{{__('Dashboard/users.createdbyuser')}}</th>
                                            <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                                            <th>{{__('Dashboard/sections_trans.updated_at')}}</th>
                                            <th> {{__('Dashboard/receipt_trans.Processes')}} </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($receipts as $receipt)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                @can('Delete Group Receipt softdelete')
                                                    <td>
                                                        <input type="checkbox" name="delete_select" value="{{$receipt->id}}" class="delete_select">
                                                    </td>
                                                @endcan
                                                @can('Restore Group Receipt')
                                                    <td>
                                                        <input type="checkbox" name="restore" value="{{$receipt->id}}" class="delete_select">
                                                    </td>
                                                @endcan
                                                <td>{{ $receipt->clients->name }}</td>
                                                <td>{{ number_format($receipt->amount, 2) }}</td>
                                                <td>{{ \Str::limit($receipt->description, 50) }}</td>
                                                <td><a href="#">{{$receipt->user->name}}</a> </td>
                                                <td> {{ $receipt->created_at->diffForHumans() }} </td>
                                                <td> {{ $receipt->updated_at->diffForHumans() }} </td>
                                                <td>
                                                    @can('Restore One Receipt')
                                                        <a href="{{route('restorerc', $receipt->id)}}">{{__('Dashboard/messages.restore')}}</a>
                                                    @endcan
                                                    @can('Delete Receipt softdelete')
                                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                            data-id="{{ $receipt->id }}" data-name="{{ $receipt->amount }}"
                                                            data-toggle="modal" href="#modaldemo8" title="Delete">
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
                    @can('Delete Group Receipt softdelete')
                        @include('Dashboard.dashboard_user.Receipt.delete_selectsoftdelete')
                    @endcan
                    @can('Restore Group Receipt')
                        @include('Dashboard.dashboard_user.Receipt.restoreall')
                    @endcan
                </div><!-- bd -->
            </div>
        </div>
    <!-- row closed -->

    <!-- delete -->
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">{{__('Dashboard/products.delete')}}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{route('Receipt.destroy')}}" method="post">
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

@endsection
@section('js')
    <!--Internal  Notify js -->
    <script src="{{URL::asset('dashboard/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>

    <script>
        $('#modaldemo8').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
        })
    </script>
@endsection
