@extends('Dashboard.layouts.master')
@section('title')
    {{__('Dashboard/services.card')}}
@stop
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">{{__('Dashboard/receipt_trans.theaccounts')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/services.card')}} </span>
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
                            @can('Delete All Bank Card')
                                <a class="btn btn-danger" href="{{route('Receipt.deleteallbt')}}">{{__('Dashboard/messages.Deleteall')}}</a>
                            @endcan

                            @can('Delete Group Bank Card softdelete')
                                <button type="button" class="btn btn-danger" id="btn_delete_all">{{trans('Dashboard/messages.Deletegroup')}}</button>
                            @endcan

                            @can('Restore All Bank Card')
                                <a class="btn btn-info" href="{{route('paymentgateway.restoreallPaymentgateway')}}">{{__('Dashboard/messages.restoreall')}}</a>
                            @endcan

                            @can('Restore Group Bank Card')
                                <button type="button" class="btn btn-info" id="btn_restore_all">{{__('Dashboard/messages.RestoreGroup')}}</button>
                            @endcan
                        </div>
                    </div>
                    @can('Show Bank Card')
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table key-buttons text-md-nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        @can('Delete Group Bank Card softdelete')
                                            <th> {{__('Dashboard/messages.Deletegroup')}} <input name="select_all"  id="example-select-all" type="checkbox"/></th>
                                        @endcan
                                        @can('Restore Group Bank Card')
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
                                    @foreach($paymentgateways as $paymentgateway)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            @can('Delete Group Bank Card softdelete')
                                                <td>
                                                    <input type="checkbox" name="delete_select" value="{{$paymentgateway->id}}" class="delete_select">
                                                </td>
                                            @endcan
                                            @can('Restore Group Bank Card')
                                                <td>
                                                    <input type="checkbox" name="restore" value="{{$paymentgateway->id}}" class="delete_select">
                                                </td>
                                            @endcan
                                            <td>{{ $paymentgateway->clients->name }}</td>
                                            <td>{{ number_format($paymentgateway->amount, 2) }}</td>
                                            <td>{{ \Str::limit($paymentgateway->description, 50) }}</td>
                                            <td><a href="#">{{$paymentgateway->user->name}}</a> </td>
                                            <td> {{ $paymentgateway->created_at->diffForHumans() }} </td>
                                            <td> {{ $paymentgateway->updated_at->diffForHumans() }} </td>
                                            <td>
                                                @can('Restore One Bank Card')
                                                    <a href="{{route('restorebt', $paymentgateway->id)}}">{{__('Dashboard/messages.restore')}}</a>
                                                @endcan
                                                @can('Delete Bank Card softdelete')
                                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                        data-id="{{ $paymentgateway->id }}" data-name="{{ $paymentgateway->amount }}"
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
                    @can('Delete Group Bank Card softdelete')
                        @include('Dashboard.dashboard_user.paymentgateway.delete_selectsoftdelete')
                    @endcan
                    @can('Restore Group Bank Card')
                        @include('Dashboard.dashboard_user.paymentgateway.restoreall')
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
                    <form action="{{route('paymentgateway.destroy')}}" method="post">
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
