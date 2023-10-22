@extends('Dashboard.layouts.master')
@section('title')
    {{__('Dashboard/payment_trans.payment')}}
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('Dashboard/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('dashboard/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>

    <link href="{{URL::asset('dashboard/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{URL::asset('dashboard/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}" rel="stylesheet">
    <link href="{{URL::asset('dashboard/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
    <link href="{{URL::asset('dashboard/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{URL::asset('dashboard/plugins/spectrum-colorpicker/spectrum.css')}}" rel="stylesheet">
@endsection
@section('page-header')
	<!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">{{__('Dashboard/payment_trans.theaccounts')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/payment_trans.payment')}}</span>
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
                        @can('Show Catch Payment')
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table key-buttons text-md-nowrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th> {{__('Dashboard/payment_trans.nameclient')}} </th>
                                            <th> {{__('Dashboard/payment_trans.price')}} </th>
                                            <th> {{__('Dashboard/payment_trans.descr')}} </th>
                                            <th>{{__('Dashboard/users.createdbyuser')}}</th>
                                            <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                                            <th>{{__('Dashboard/sections_trans.updated_at')}}</th>
                                            <th> {{__('Dashboard/payment_trans.Processes')}} </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($payments as $payment)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{ $payment->clients->name }}</td>
                                                    <td>{{ number_format($payment->amount, 2) }}</td>
                                                    <td>{{ \Str::limit($payment->description, 50) }}</td>
                                                    <td><a href="#">{{$payment->user->name}}</a> </td>
                                                    <td> {{ $payment->created_at->diffForHumans() }} </td>
                                                    <td> {{ $payment->updated_at->diffForHumans() }} </td>
                                                    <td>
                                                        <a href="{{route('restorepy', $payment->id)}}">{{__('Dashboard/messages.restore')}}</a>
                                                        <form action="{{route('forcedeletepy', $payment->id)}}" method="get">
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

@endsection
@section('js')
    <!--Internal  Notify js -->
    <script src="{{URL::asset('dashboard/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>
@endsection
