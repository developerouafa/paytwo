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
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table key-buttons text-md-nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
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
                                            <td>{{ $banktransfer->clients->name }}</td>
                                            <td>{{ number_format($banktransfer->amount, 2) }}</td>
                                            <td>{{ \Str::limit($banktransfer->description, 50) }}</td>
                                            <td><a href="#">{{$banktransfer->user->name}}</a> </td>
                                            <td> {{ $banktransfer->created_at->diffForHumans() }} </td>
                                            <td> {{ $banktransfer->updated_at->diffForHumans() }} </td>
                                            <td>
                                                <a href="{{route('restorebt', $banktransfer->id)}}">{{__('Dashboard/messages.restore')}}</a>
                                                <form action="{{route('forcedeletebt', $banktransfer->id)}}" method="get">
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
    <script src="{{URL::asset('dashboard/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>
@endsection
