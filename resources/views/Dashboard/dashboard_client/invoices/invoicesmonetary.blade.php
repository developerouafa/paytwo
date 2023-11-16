@extends('Dashboard.layouts.master')
@section('title')
    {{__('Dashboard/main-sidebar_trans.Listofinvoices')}} {{__('Dashboard/services.monetary')}}
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/main-sidebar_trans.Listofinvoices')}} {{__('Dashboard/services.monetary')}}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/main-sidebar_trans.view_all')}}</span>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- row -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example-1" class="table key-buttons text-md-nowrap" data-page-length="50" style="text-align: center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th> {{__('Dashboard/services.print')}} </th>
                                        <th> {{__('Dashboard/services.invoicenumber')}} </th>
                                        <th> {{__('Dashboard/services.nameservice')}} </th>
                                        <th> {{__('Dashboard/receipt_trans.Catch Receipt')}} </th>
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
                                    @foreach($invoices as $invoice)
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
                                            <td>
                                                @if ($fund_accountreceipt)
                                                    @if ($fund_accountreceipt->invoice->id == $invoice->id)
                                                        <a href="{{route('Invoices.showinvoicereceipt',$invoice->id)}}">{{__('Dashboard/receipt_trans.viewreceipt')}}</a>
                                                    @else
                                                        {{__('Dashboard/receipt_trans.noreceipt')}}
                                                    @endif
                                                @else
                                                {{__('Dashboard/receipt_trans.noreceipt')}}
                                                @endif
                                            </td>
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
                                                        <a href="{{route('Invoices.receipt',$invoice->id)}}" class="btn btn-primary btn-sm" target="_blank"><i class="fas fa-print"></i>{{__('Dashboard/clients_trans.cashpaymentmn')}}</a>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- row closed -->
@endsection
@section('js')

    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>

@endsection
