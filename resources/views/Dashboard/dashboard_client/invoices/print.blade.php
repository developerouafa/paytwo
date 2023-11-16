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
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice" id="print">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            @if ($invoice->invoice_classify == '1')
                                <h1 class="invoice-title"> {{__('Dashboard/services.Singleservicebill')}} </h1>
                            @else
                                <h1 class="invoice-title">{{__('Dashboard/services.Servicebill')}}</h1>
                            @endif
                            <div class="billed-from">
                                <h6> {{__('Dashboard/messages.BilledTo')}} </h6>
                                <p> {{$invoice->user->name}} <br>
                                    {{__('Dashboard/users.phone')}}: {{$invoice->user->phone}} <br>
                                    {{__('Dashboard/users.email')}}: {{$invoice->user->email}} </p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">{{__('Dashboard/services.invoiceinformation')}}</label>
                                <p class="invoice-info-row"><span>{{__('Dashboard/services.invoicenumber')}}</span> <span>{{$invoice->invoice_number}}</span></p>
                                @if ($invoice->invoice_classify == '1')
                                    <p class="invoice-info-row"><span>{{__('Dashboard/services.Servicebill')}}</span> <span>{{$invoice->Service->name}}</span></p>
                                @else
                                    <p class="invoice-info-row"><span>{{__('Dashboard/services.Servicebill')}}</span> <span>{{$invoice->Group->name}}</span></p>
                                @endif
                                <p class="invoice-info-row"><span>{{__('Dashboard/services.clientphone')}}</span> <span>{{$invoice->Client->name}} - {{$invoice->Client->phone}}</span></p>
                                <p class="invoice-info-row"><span>{{__('Dashboard/services.dateinvoice')}}</span> <span> {{$invoice->invoice_date}} </span></p>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                <tr>
                                    <th class="wd-40p"> {{__('Dashboard/services.invoicenumber')}} </th>
                                    <th class="wd-40p"> {{__('Dashboard/services.nameservice')}} </th>
                                    <th class="tx-center"> {{__('Dashboard/services.priceservice')}} </th>
                                    <th class="tx-right"> {{__('Dashboard/services.type')}} </th>
                                    <th class="tx-right"> {{__('Dashboard/services.Invoicetype')}} </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="tx-12">{{ $invoice->invoice_number }}</td>
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
                                    <td class="tx-right">
                                        @if ($invoice->invoice_type == 1)
                                            {{__('Dashboard/services.Draft')}}
                                        @elseif ($invoice->invoice_type == 2)
                                            {{__('Dashboard/services.Paid')}}
                                        @elseif ($invoice->invoice_type == 3)
                                            {{__('Dashboard/services.Canceled')}}
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
                        @if ($invoice->invoice_type == 1)
                            <a class="btn btn-purple float-left mt-3 mr-2" href="{{route('Invoices.showinvoice',$invoice->id)}}">
                                <i class="mdi mdi-currency-usd ml-1"></i>
                                {{__('Dashboard/clients_trans.Pay')}}
                            </a>
                        @elseif ($invoice->invoice_type == 2)
                            <a class="btn btn-purple float-left mt-3 mr-2" href="">{{__('Dashboard/services.Paid')}}</a>
                        @elseif ($single_invoice->invoice_type == 3)
                            <a class="btn btn-purple float-left mt-3 mr-2" href="">{{__('Dashboard/services.Canceled')}}</a>
                        @endif
                        <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                            <i class="mdi mdi-printer ml-1"></i>{{__('Dashboard/services.print')}}
                        </a>
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
