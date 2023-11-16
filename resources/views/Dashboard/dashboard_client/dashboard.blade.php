@extends('Dashboard/layouts.master')
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
@endsection
@section('title')
   {{__('Dashboard/index.Billingmanagement')}}
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{__('Dashboard/clients_trans.Clientcontrolpanel')}}</h2>
                <p class="mg-b-0">{{__('Dashboard/clients_trans.Salesmonitoringdashb')}} <b>{{auth()->user()->name}}</b> </p>
            </div>
        </div>
        <div class="main-dashboard-header-right">
            <div>
                <label class="tx-13">{{__('Dashboard/clients_trans.countinvoiceclient')}}</label>
                <h5>{{ App\Models\invoice::where('client_id', auth()->user()->id)->count() }}</h5>
            </div>
        </div>
    </div>
@endsection
@section('content')
        <!-- row -->
            <div class="row row-sm">
                <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-primary-gradient">
                        <div class="pl-3 pt-3 pr-3 pb-2">
                            <div class="">
                                <h6 class="mb-3 tx-12 text-white">اجمالي المدفوعات </h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div class="">
                                        <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                            {{App\Models\client_account::where('client_id',auth()->user()->id)->sum('credit')}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-danger-gradient">
                        <div class="pl-3 pt-3 pr-3 pb-2 ">
                            <div class="">
                                <h6 class="mb-3 tx-12 text-white">عدد الفواتير تحت الاجراء</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div class="">
                                        <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                            {{App\Models\invoice::where('client_id',auth()->user()->id)->where('invoice_status',1)->count()}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-success-gradient">
                        <div class="pl-3 pt-3 pr-3 pb-2 ">
                            <div class="">
                                <h6 class="mb-3 tx-12 text-white">عدد الفواتير المكتملة</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div class="">
                                        <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                            {{App\Models\invoice::where('client_id',auth()->user()->id)->where('invoice_status',3)->count()}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-warning-gradient">
                        <div class="pl-3 pt-3 pr-3 pb-2 ">
                            <div class="">
                                <h6 class="mb-3 tx-12 text-white">عدد فواتير المراجعات</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div class="">
                                        <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                            {{App\Models\invoice::where('client_id',auth()->user()->id)->where('invoice_status',2)->count()}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                    </div>
                </div>
            </div>
        <!-- row closed -->

            <div class="row row-sm row-deck">
                <div class="col-md-12 col-lg-12 col-xl-12">
                    <div class="card card-table-two">
                        <div class="d-flex justify-content-between">
                            <h2 class="card-title mb-1">{{__('Dashboard/clients_trans.lastinvoices')}}</h2>
                        </div><br>
                        <div class="table-responsive country-table">
                            <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th> {{__('Dashboard/services.print')}} </th>
                                    <th> {{__('Dashboard/services.invoicenumber')}} </th>
                                    <th> {{__('Dashboard/services.nameservice')}} </th>
                                    <th> {{__('Dashboard/services.client')}} </th>
                                    <th> {{__('Dashboard/services.dateinvoice')}} </th>
                                    <th> {{__('Dashboard/services.priceservice')}} </th>
                                    <th> {{__('Dashboard/services.discountvalue')}} </th>
                                    <th> {{__('Dashboard/services.Taxrate')}} </th>
                                    <th> {{__('Dashboard/services.Taxvalue')}} </th>
                                    <th> {{__('Dashboard/services.Totalwithtax')}} </th>
                                    <th> {{__('Dashboard/services.Invoicestatus')}} </th>
                                    <th> {{__('Dashboard/services.Invoicetype')}} </th>
                                    <th> {{__('Dashboard/users.createdbyuser')}} </th>
                                    <th> {{__('Dashboard/sections_trans.created_at')}} </th>
                                    <th> {{__('Dashboard/sections_trans.updated_at')}} </th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse(\App\Models\Invoice::latest()->take(5)->where('client_id',auth()->user()->id)->get() as $invoice )
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <a href="{{route('Invoices.print', $invoice->id)}}" class="btn btn-primary btn-sm" target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </td>
                                        <td>
                                            @if ($invoice->invoice_type == 1)
                                                <a href="{{route('Invoices.showinvoice',$invoice->id)}}">{{$invoice->invoice_number}}</a>
                                            @else
                                                {{$invoice->invoice_number}}
                                            @endif
                                        </td>
                                        @if ($invoice->invoice_classify == 1)
                                            <td>
                                                <a href="{{route('Invoices.showService', $invoice->Service->id)}}">{{ $invoice->Service->name }}</a>
                                            </td>
                                        @elseif ($invoice->invoice_classify == 2)
                                            <td>
                                                <a href="{{route('Invoices.showServices', $invoice->Group->id)}}">{{ $invoice->Group->name }}</a>
                                            </td>
                                        @endif
                                        <td>{{ $invoice->Client->name }}</td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ number_format($invoice->price, 2) }}</td>
                                        <td>{{ number_format($invoice->discount_value, 2) }}</td>
                                        <td>{{ $invoice->tax_rate }}%</td>
                                        <td>{{ number_format($invoice->tax_value, 2) }}</td>
                                        <td>{{ number_format($invoice->total_with_tax, 2) }}</td>
                                        <td>
                                            @if ($invoice->invoice_status == 1)
                                                {{__('Dashboard/services.Sent')}}
                                            @elseif ($invoice->invoice_status == 2)
                                                {{__('Dashboard/services.Under review')}}
                                            @elseif ($invoice->invoice_status == 3)
                                                {{__('Dashboard/services.Complete')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($invoice->invoice_type == 1)
                                                {{__('Dashboard/services.Draft')}}
                                            @elseif ($invoice->invoice_type == 2)
                                                {{__('Dashboard/services.Paid')}}
                                            @elseif ($invoice->invoice_type == 3)
                                                {{__('Dashboard/services.Canceled')}}
                                            @endif
                                        </td>
                                        <td class="tx-medium tx-danger">{{$invoice->user->name}}</td>
                                        <td class="tx-medium tx-inverse"> {{ $invoice->created_at->diffForHumans() }} </td>
                                        <td class="tx-medium tx-inverse"> {{ $invoice->updated_at->diffForHumans() }} </td>
                                    </tr>
                                @empty
                                    {{__('Dashboard/messages.database')}}
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <!-- Moment js -->
    <script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
    <!--Internal  Flot js-->
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
    <script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
    <script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
    <!--Internal Apexchart js-->
    <script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
    <!-- Internal Map -->
    <script src="{{URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal-popup.js')}}"></script>
    <!--Internal  index js -->
    <script src="{{URL::asset('assets/js/index.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.vmap.sampledata.js')}}"></script>
@endsection
