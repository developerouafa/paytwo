@extends('Dashboard.layouts.master')
@section('title')
    {{__('Dashboard/receipt_trans.receipt')}}
@stop
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">{{__('Dashboard/receipt_trans.theaccounts')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/receipt_trans.receipt')}} </span>
                </div>
            </div>
        </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    <!-- row -->
        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            @can('Delete All Bank Tranktransfer')
                                <a class="btn btn-danger" href="{{route('Receipt.deleteallbt')}}">{{__('Dashboard/messages.Deleteall')}}</a>
                            @endcan

                            @can('Delete Group Bank Tranktransfer softdelete')
                                <button type="button" class="btn btn-danger" id="btn_delete_all">{{trans('Dashboard/messages.Deletegroup')}}</button>
                            @endcan

                            @can('Restore All Bank Tranktransfer')
                                <a class="btn btn-info" href="{{route('Banktransfer.restoreallBanktransfer')}}">{{__('Dashboard/messages.restoreall')}}</a>
                            @endcan

                            @can('Restore Group Bank Tranktransfer')
                                <button type="button" class="btn btn-info" id="btn_restore_all">{{__('Dashboard/messages.RestoreGroup')}}</button>
                            @endcan
                        </div>
                    </div>
                    @can('Show Bank Tranktransfer')
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table key-buttons text-md-nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        @can('Delete Group Bank Tranktransfer softdelete')
                                            <th><input name="select_all"  id="example-select-all" type="checkbox"/></th>
                                        @endcan
                                        @can('Restore Group Bank Tranktransfer')
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
                                    @foreach($banktransfers as $banktransfer)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            @can('Delete Group Bank Tranktransfer softdelete')
                                                <td>
                                                    <input type="checkbox" name="delete_select" value="{{$banktransfer->id}}" class="delete_select">
                                                </td>
                                            @endcan
                                            @can('Restore Group Bank Tranktransfer')
                                                <td>
                                                    <input type="checkbox" name="restore" value="{{$banktransfer->id}}" class="delete_select">
                                                </td>
                                            @endcan
                                            <td>{{ $banktransfer->clients->name }}</td>
                                            <td>{{ number_format($banktransfer->amount, 2) }}</td>
                                            <td>{{ \Str::limit($banktransfer->description, 50) }}</td>
                                            <td><a href="#">{{$banktransfer->user->name}}</a> </td>
                                            <td> {{ $banktransfer->created_at->diffForHumans() }} </td>
                                            <td> {{ $banktransfer->updated_at->diffForHumans() }} </td>
                                            <td>
                                                @can('Restore One Bank Tranktransfer')
                                                    <a href="{{route('restorebt', $banktransfer->id)}}">{{__('Dashboard/messages.restore')}}</a>
                                                @endcan
                                                @can('Delete Bank Tranktransfer softdelete')
                                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                        data-id="{{ $banktransfer->id }}" data-name="{{ $banktransfer->amount }}"
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
                    @can('Delete Group Bank Tranktransfer softdelete')
                        @include('Dashboard.dashboard_user.banktransfer.delete_selectsoftdelete')
                    @endcan
                    @can('Restore Group Bank Tranktransfer')
                        @include('Dashboard.dashboard_user.banktransfer.restoreall')
                    @endcan
                </div><!-- bd -->
            </div>
            <!--/div-->

        <!-- delete -->
        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">{{__('Dashboard/products.delete')}}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{route('Banktransfer.destroy')}}" method="post">
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

    </div>
    <!-- row closed -->

			<!-- Container closed -->

		<!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Notify js -->
    <script src="{{URL::asset('dashboard/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>
@endsection
