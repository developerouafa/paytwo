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
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                @can('Create Catch Payment')
                                    <a href="{{route('Payment.create')}}" class="btn btn-primary" role="button" aria-pressed="true"> {{__('Dashboard/payment_trans.addpayment')}} </a>
                                @endcan

                                @can('Delete All Catch Payment')
                                    <a class="btn btn-danger" href="{{route('Payment.deleteall')}}">{{__('Dashboard/messages.Deleteall')}}</a>
                                @endcan

                                @can('Delete Group Catch Payment')
                                    <button type="button" class="btn btn-danger" id="btn_delete_all">{{trans('Dashboard/messages.Deletegroup')}}</button>
                                @endcan
                            </div>
                        </div>
                        @can('Show Catch Payment')
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table key-buttons text-md-nowrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><input name="select_all"  id="example-select-all" type="checkbox"/></th>
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
                                                    <td>
                                                        <input type="checkbox" name="delete_select" value="{{$payment->id}}" class="delete_select">
                                                    </td>
                                                    <td>{{ $payment->clients->name }}</td>
                                                    <td>{{ number_format($payment->amount, 2) }}</td>
                                                    <td>{{ \Str::limit($payment->description, 50) }}</td>
                                                    <td><a href="#">{{$payment->user->name}}</a> </td>
                                                    <td> {{ $payment->created_at->diffForHumans() }} </td>
                                                    <td> {{ $payment->updated_at->diffForHumans() }} </td>
                                                    <td>
                                                        @can('Edit Catch Payment')
                                                            <a href="{{route('Payment.edit',$payment->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                                        @endcan

                                                        @can('Delete Catch Payment')
                                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"  data-toggle="modal" href="#delete{{$payment->id}}"><i class="las la-trash"></i></a>
                                                        @endcan

                                                        @can('Print Catch Payment')
                                                            <a href="{{route('Payment.show',$payment->id)}}" class="btn btn-primary btn-sm" target="_blank"><i class="fas fa-print"></i></a>
                                                        @endcan
                                                    </td>
                                                </tr>
                                                    @include('Dashboard.dashboard_user.Payment.delete')
                                                    @include('Dashboard.dashboard_user.Payment.delete_select')
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
