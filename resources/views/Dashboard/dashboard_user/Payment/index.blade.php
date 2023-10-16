@extends('Dashboard.layouts.master')
@section('title')
    {{__('Dashboard/receipt_trans.payment')}}
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
                    <h4 class="content-title mb-0 my-auto">{{__('Dashboard/payment_trans.theaccounts')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/receipt_trans.payment')}}</span>
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
                            <a href="{{route('Payment.create')}}" class="btn btn-primary" role="button"
                                aria-pressed="true"> {{__('Dashboard/payment_trans.addpayment')}} </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap" id="example1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th> {{__('Dashboard/payment_trans.nameclient')}} </th>
                                    <th> {{__('Dashboard/payment_trans.price')}} </th>
                                    <th> {{__('Dashboard/payment_trans.descr')}} </th>
                                    <th class="wd-20p border-bottom-0">{{__('Dashboard/users.createdbyuser')}}</th>
                                    <th class="wd-20p border-bottom-0">{{__('Dashboard/sections_trans.created_at')}}</th>
                                    <th class="wd-20p border-bottom-0">{{__('Dashboard/sections_trans.updated_at')}}</th>
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
                                                <a href="{{route('Payment.edit',$payment->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"  data-toggle="modal" href="#delete{{$payment->id}}"><i class="las la-trash"></i></a>
                                                <a href="{{route('Payment.show',$payment->id)}}" class="btn btn-primary btn-sm" target="_blank"><i class="fas fa-print"></i></a>

                                            </td>
                                        </tr>
                                            @include('Dashboard.dashboard_user.Payment.delete')
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


    <!--Internal  Datepicker js -->
    <script src="{{URL::asset('dashboard/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{URL::asset('dashboard/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{URL::asset('dashboard/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{URL::asset('dashboard/plugins/select2/js/select2.min.js')}}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{URL::asset('dashboard/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{URL::asset('dashboard/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
    <!-- Ionicons js -->
    <script src="{{URL::asset('dashboard/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{URL::asset('dashboard/plugins/pickerjs/picker.min.js')}}"></script>
    <!-- Internal form-elements js -->
    <script src="{{URL::asset('dashboard/js/form-elements.js')}}"></script>

@endsection
