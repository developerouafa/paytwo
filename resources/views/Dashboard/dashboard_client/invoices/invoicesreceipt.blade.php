@extends('Dashboard.layouts.master')
@section('title')
    {{__('Dashboard/main-sidebar_trans.Listofinvoices')}} {{__('Dashboard/clients_trans.cashpaymentmn')}}
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
                    <h4 class="content-title mb-0 my-auto">{{__('Dashboard/main-sidebar_trans.Listofinvoices')}} {{__('Dashboard/main-sidebar_trans.cashpaymentmn')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/main-sidebar_trans.view_all')}}</span>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example-1" class="table key-buttons text-md-nowrap" data-page-length="50" style="text-align: center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th> {{__('Dashboard/services.invoicenumber')}} </th>
                                        <th> {{__('Dashboard/receipt_trans.price')}} </th>
                                        <th> {{__('Dashboard/receipt_trans.descr')}} </th>
                                        <th> {{__('Dashboard/services.dateinvoice')}} </th>
                                        <th> {{__('Dashboard/users.createdbyuser')}} </th>
                                        <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                                        <th>{{__('Dashboard/sections_trans.updated_at')}}</th>
                                        <th>{{__('Dashboard/receipt_trans.Print a document')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fund_accounts as $invoice)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td><a href="{{route('Invoices.showinvoicemonetary', $invoice->invoice_id)}}">{{$invoice->invoice->invoice_number}}</a> </td>
                                            <td>{{ $invoice->receiptaccount->amount }}</td>
                                            <td>{{ $invoice->receiptaccount->description }}</td>
                                            <td>{{ $invoice->receiptaccount->date }}</td>
                                            <td class="tx-medium tx-danger">{{$invoice->receiptaccount->user->name}}</td>
                                            <td class="tx-medium tx-inverse"> {{ $invoice->receiptaccount->created_at->diffForHumans() }} </td>
                                            <td class="tx-medium tx-inverse"> {{ $invoice->receiptaccount->updated_at->diffForHumans() }} </td>
                                            <td class="tx-medium tx-inverse">
                                                <a href="{{route('Invoices.printreceipt', $invoice->receiptaccount->id)}}" class="btn btn-primary btn-sm" target="_blank"><i class="fas fa-print"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>

@endsection
