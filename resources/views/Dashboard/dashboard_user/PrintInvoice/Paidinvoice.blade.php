@extends('Dashboard.layouts.master')
@section('title')
    {{__('Dashboard/services.printinvoices')}}
@stop
@section('css')
    <style>
        @media print {
            #print_Button {
                display: none;
            }
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/services.invoices')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/services.printinvoices')}}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if($invoice->invoice_status == 3)
    <div class="card">
        <div class="card-body">
            <div class="tabs-menu ">
                <!-- Tabs -->
                <ul class="nav nav-tabs profile navtab-custom panel-tabs">
                    <li class="active">
                        <a href="#home" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs">{{__('Dashboard/clients_trans.confirmpayment')}}</span> </a>
                    </li>
                    <li class="">
                        <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs">{{__('Dashboard/clients_trans.paymentrefused')}}</span> </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content border-left border-bottom border-right border-top-0 p-4">
                <div class="tab-pane active" id="home">
                    <form method="post" action="{{ route('Invoice.confirmpayment') }}" class="mt-6 space-y-6" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <textarea class="form-control" name="descriptiontoclient" placeholder="{{__('Dashboard/services.description')}} {{__('Dashboard/clients_trans.confirmpayment')}}"></textarea>
                            <input type="hidden" value="{{$invoice->id}}" name="invoice_id">
                        </div>
                        <button class="btn btn-primary waves-effect waves-light w-md" type="submit">{{__('Dashboard/services.save')}}</button>
                    </form>
                </div>
                <div class="tab-pane" id="settings">
                    <form method="post" action="{{ route('Invoice.refusedpayment') }}" class="mt-6 space-y-6" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <textarea id="AboutMe" class="form-control" name="descriptiontoclient" placeholder="{{__('Dashboard/services.description')}} {{__('Dashboard/clients_trans.paymentrefused')}}"></textarea>
                            <input type="hidden" value="{{$invoice->id}}" name="invoice_id">
                        </div>
                        <button class="btn btn-primary waves-effect waves-light w-md" type="submit">{{__('Dashboard/services.save')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice" id="print">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title"> {{__('Dashboard/services.Singleservicebill')}} </h1>
                            <div class="billed-from">
                                <h6> {{__('Dashboard/services.Singleservicebill')}} </h6>
                                <p> {{$invoice->user->name}} <br>
                                    {{__('Dashboard/users.phone')}}: {{$invoice->user->phone}} <br>
                                    {{__('Dashboard/users.email')}}: {{$invoice->user->email}} </p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">{{__('Dashboard/services.invoiceinformation')}}</label>
                                @if ($invoice->invoice_classify == '1')
                                    <p class="invoice-info-row"><span>{{__('Dashboard/services.Servicebill')}}</span> <span>{{$invoice->Service->name}}</span></p>
                                @else
                                    <p class="invoice-info-row"><span>{{__('Dashboard/services.clientphone')}}</span> <span>{{$invoice->Client->name}} - {{$invoice->Client->phone}}</span></p>
                                @endif
                                <p class="invoice-info-row"><span>{{__('Dashboard/services.clientphone')}}</span> <span>{{$invoice->Client->name}} - {{$invoice->Client->phone}}</span></p>
                                <p class="invoice-info-row"><span>{{__('Dashboard/services.dateinvoice')}}</span> <span> {{$invoice->invoice_date}} </span></p>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                <tr>
                                    <th class="wd-20p">#</th>
                                    <th class="wd-40p"> {{__('Dashboard/services.nameservice')}} </th>
                                    <th class="tx-center"> {{__('Dashboard/services.priceservice')}} </th>
                                    <th class="tx-right"> {{__('Dashboard/services.Invoicetype')}} </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td class="tx-12">
                                        @if ($invoice->invoice_classify == '1')
                                            {{ $invoice->Service->name }}
                                        @else
                                            {{ $invoice->Group->name }}
                                        @endif
                                    </td>

                                    <td class="tx-center">{{ $invoice->price }}</td>
                                    <td class="tx-right">
                                        @if ($invoice->type == 0)
                                            {{__('Dashboard/sections_trans.nosectionyet')}}
                                        @elseif ($invoice->type == 1)
                                            {{__('Dashboard/services.monetary')}}
                                        @elseif ($invoice->type == 2)
                                            {{__('Dashboard/services.Okay')}}
                                        @elseif ($invoice->type == 3)
                                            {{__('Dashboard/services.Banktransfer')}}
                                        @elseif ($invoice->type == 4)
                                            {{__('Dashboard/services.card')}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="valign-middle" colspan="2" rowspan="4">
                                        <div class="invoice-notes">
                                            <label class="main-content-label tx-13"></label>
                                        </div><!-- invoice-notes -->
                                    </td>
                                    <td class="tx-right"> {{__('Dashboard/services.Total')}} </td>
                                    <td class="tx-right" colspan="2"> {{number_format($invoice->price, 2)}}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right"> {{__('Dashboard/services.discountvalue')}} </td>
                                    <td class="tx-right" colspan="2">{{$invoice->discount_value}}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right"> {{__('Dashboard/services.Taxrate')}} </td>
                                    <td class="tx-right" colspan="2">% {{$invoice->tax_value}}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right tx-uppercase tx-bold tx-inverse"> {{__('Dashboard/services.totalincludingtax')}} </td>
                                    <td class="tx-right" colspan="2">
                                        <h4 class="tx-primary tx-bold">{{number_format($invoice->total_with_tax, 2)}}</h4>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mg-b-40">

                        @if ($receiptdocument)
                        <embed src="{{asset('storage/'.$receiptdocument->invoice)}}" width="100%" height="1000px" />
                        @endif

                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{URL::asset('Admin/assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>


    <script type="text/javascript">
        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@endsection
