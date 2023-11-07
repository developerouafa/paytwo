@extends('Dashboard.layouts.master')
@section('css')

@endsection

@section('title')
    {{$client->name}} / {{trans('Dashboard/services.invoices')}}
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{$client->name}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{trans('Dashboard/services.invoices')}}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row row-sm">
        <h1 style="color: blue">{{__('Dashboard/services.noselectionyet')}}</h1>
        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped mg-b-0 text-md-nowrap table-hover">
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
                                @foreach($invoices as $invoice)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                <a href="{{route('Clients.clientinvoice', $invoice->id)}}" class="btn btn-primary btn-sm" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            </td>
                                            <td>
                                                {{$invoice->invoice_number}}
                                            </td>
                                            @if ($invoice->invoice_classify == 1)
                                                <td>{{ $invoice->Service->name }}</td>
                                            @elseif ($invoice->invoice_classify == 2)
                                                <td>{{ $invoice->Group->name }}</td>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->

        <h1 style="color: blue">{{__('Dashboard/clients_trans.cashpyinvoice')}}</h1>
        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped mg-b-0 text-md-nowrap table-hover">
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
                                @foreach($invoicescatchpayment as $invoice)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                <a href="{{route('Clients.clientinvoice', $invoice->id)}}" class="btn btn-primary btn-sm" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            </td>
                                            <td>
                                                {{$invoice->invoice_number}}
                                            </td>
                                            @if ($invoice->invoice_classify == 1)
                                                <td>{{ $invoice->Service->name }}</td>
                                            @elseif ($invoice->invoice_classify == 2)
                                                <td>{{ $invoice->Group->name }}</td>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->

        <h1 style="color:darkred">{{__('Dashboard/clients_trans.cashpyinvoicepaid')}}</h1>
        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped mg-b-0 text-md-nowrap table-hover">
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
                                @foreach($invoicespostpaid as $invoice)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                <a href="{{route('Clients.clientinvoice', $invoice->id)}}" class="btn btn-primary btn-sm" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            </td>
                                            <td>
                                                {{$invoice->invoice_number}}
                                            </td>
                                            @if ($invoice->invoice_classify == 1)
                                                <td>{{ $invoice->Service->name }}</td>
                                            @elseif ($invoice->invoice_classify == 2)
                                                <td>{{ $invoice->Group->name }}</td>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->

        <h1 style="color:darkblue">{{__('Dashboard/clients_trans.banktransferpy')}}</h1>
        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped mg-b-0 text-md-nowrap table-hover">
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
                                @foreach($invoicesbanktransfer as $invoice)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                <a href="{{route('Clients.clientinvoice', $invoice->id)}}" class="btn btn-primary btn-sm" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            </td>
                                            <td>
                                                {{$invoice->invoice_number}}
                                            </td>
                                            @if ($invoice->invoice_classify == 1)
                                                <td>{{ $invoice->Service->name }}</td>
                                            @elseif ($invoice->invoice_classify == 2)
                                                <td>{{ $invoice->Group->name }}</td>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->

        <h1 style="color:orangered">{{__('Dashboard/clients_trans.bankcardpy')}}</h1>
        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped mg-b-0 text-md-nowrap table-hover">
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
                                @foreach($invoicescard as $invoice)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                <a href="{{route('Clients.clientinvoice', $invoice->id)}}" class="btn btn-primary btn-sm" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            </td>
                                            <td>
                                                {{$invoice->invoice_number}}
                                            </td>
                                            @if ($invoice->invoice_classify == 1)
                                                <td>{{ $invoice->Service->name }}</td>
                                            @elseif ($invoice->invoice_classify == 2)
                                                <td>{{ $invoice->Group->name }}</td>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->

    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@endsection
