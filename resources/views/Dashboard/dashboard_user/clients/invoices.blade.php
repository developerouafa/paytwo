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

    {{-- Information Client --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table text-md-nowrap" id="example-1" data-page-length="50" style="text-align: center">
                    <thead>
                        <tr>
                            <th class="wd-15p border-bottom-0">#</th>
                            <th class="wd-15p border-bottom-0">{{__('Dashboard/clients_trans.name')}}</th>
                            <th class="wd-15p border-bottom-0">{{__('Dashboard/users.email')}}</th>
                            <th class="wd-15p border-bottom-0">{{__('Dashboard/clients_trans.phone')}}</th>
                            <th class="wd-15p border-bottom-0">{{__('Dashboard/clients_trans.status')}}</th>
                            <th class="wd-20p border-bottom-0">{{__('Dashboard/users.createdbyuser')}}</th>
                            <th class="wd-20p border-bottom-0">{{__('Dashboard/products.created_at')}}</th>
                            <th class="wd-20p border-bottom-0">{{__('Dashboard/sections_trans.updated_at')}}</th>
                            <th class="wd-20p border-bottom-0"></th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td>{{$client->id}}</td>
                                <td>{{$client->name}}</td>
                                <td>{{$client->email}}</td>
                                <td>{{$client->phone}}</td>
                                <td>
                                    @if ($client->Status == 1)
                                        <a href="{{route('editstatusdéactivecl', $client->id)}}" class="dropdown-item">
                                            <i class="text-warning ti-back-right"></i>
                                            {{__('Dashboard/clients_trans.disabled')}}
                                        </a>
                                    @endif
                                    @if ($client->Status == 0)
                                        <a href="{{route('editstatusactivecl', $client->id)}}" class="dropdown-item">
                                            <i class="text-warning ti-back-right"></i>
                                            {{__('Dashboard/clients_trans.active')}}
                                        </a>
                                    @endif
                                </td>
                                <td>{{$client->user->name}} </td>
                                <td> {{ $client->created_at->diffForHumans() }} </td>
                                <td> {{ $client->updated_at->diffForHumans() }} </td>
                                <td>
                                    <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"  data-toggle="modal" href="#edit{{$client->id}}"><i class="las la-pen"></i></a>
                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"  data-toggle="modal" href="#delete{{$client->id}}"><i class="las la-trash"></i></a>
                                </td>
                            </tr>

                            @can('Edit Client')
                                @include('Dashboard.dashboard_user.clients.edit')
                            @endcan

                            @can('Delete Client')
                                @include('Dashboard.dashboard_user.clients.delete')
                            @endcan

                            @can('Delete Group Client')
                                @include('Dashboard.dashboard_user.clients.delete_select')
                            @endcan

                    </tbody>
                </table>
            </div>
        </div><!-- bd -->
    </div>

    {{-- Invoices Client --}}
    <div class="card">
        <div class="card-body">
            <div class="tabs-menu ">
                <!-- Tabs -->
                <ul class="nav nav-tabs profile navtab-custom panel-tabs">
                    <li class="active">
                        <a href="#allinvoices" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs">{{__('Dashboard/services.invoices')}}</span> </a>
                    </li>
                    <li class="">
                        <a href="#noselectionyet" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs">{{__('Dashboard/services.noselectionyet')}}</span> </a>
                    </li>
                    <li class="">
                        <a href="#cashpyinvoice" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs">{{__('Dashboard/clients_trans.cashpyinvoice')}}</span> </a>
                    </li>
                    <li class="">
                        <a href="#cashpyinvoicepaid" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs">{{__('Dashboard/clients_trans.cashpyinvoicepaid')}}</span> </a>
                    </li>
                    <li class="">
                        <a href="#banktransferpy" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs">{{__('Dashboard/clients_trans.banktransferpy')}}</span> </a>
                    </li>
                    <li class="">
                        <a href="#bankcardpy" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs">{{__('Dashboard/clients_trans.bankcardpy')}}</span> </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content border-left border-bottom border-right border-top-0 p-4">
                <div class="tab-pane active" id="allinvoices">
                    <h1 style="color:deeppink">{{__('Dashboard/services.invoices')}}</h1>
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
                </div>
                <div class="tab-pane" id="noselectionyet">
                    <h1 style="color:purple">{{__('Dashboard/services.noselectionyet')}}</h1>
                    <!--div-->
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example-11" class="table table-striped mg-b-0 text-md-nowrap table-hover">
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
                                            @foreach($invoicesnomethodpay as $invoice)
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
                <div class="tab-pane" id="cashpyinvoice">
                    <h1 style="color: blue">{{__('Dashboard/clients_trans.cashpyinvoice')}}</h1>
                    <!--div-->
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example-12" class="table table-striped mg-b-0 text-md-nowrap table-hover">
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
                </div>
                <div class="tab-pane" id="cashpyinvoicepaid">
                    <h1 style="color:darkred">{{__('Dashboard/clients_trans.cashpyinvoicepaid')}}</h1>
                    <!--div-->
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example-13" class="table table-striped mg-b-0 text-md-nowrap table-hover">
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
                </div>
                <div class="tab-pane" id="banktransferpy">
                    <h1 style="color:darkblue">{{__('Dashboard/clients_trans.banktransferpy')}}</h1>
                    <!--div-->
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example-14" class="table table-striped mg-b-0 text-md-nowrap table-hover">
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
                </div>
                <div class="tab-pane" id="bankcardpy">
                    <h1 style="color:orangered">{{__('Dashboard/clients_trans.bankcardpy')}}</h1>
                    <!--div-->
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example-15" class="table table-striped mg-b-0 text-md-nowrap table-hover">
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
            </div>
        </div>
    </div>

    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script>
        $(function(e) {
            //Details display datatable
            $('#example-11').DataTable( {
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_',
                },
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal( {
                            header: function ( row ) {
                                var data = row.data();
                                return 'Details for '+data[0]+' '+data[1];
                            }
                        } ),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                            tableClass: 'table border mb-0'
                        } )
                    }
                }
            } );
            //Details display datatable
            $('#example-12').DataTable( {
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_',
                },
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal( {
                            header: function ( row ) {
                                var data = row.data();
                                return 'Details for '+data[0]+' '+data[1];
                            }
                        } ),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                            tableClass: 'table border mb-0'
                        } )
                    }
                }
            } );
            //Details display datatable
            $('#example-13').DataTable( {
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_',
                },
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal( {
                            header: function ( row ) {
                                var data = row.data();
                                return 'Details for '+data[0]+' '+data[1];
                            }
                        } ),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                            tableClass: 'table border mb-0'
                        } )
                    }
                }
            } );
            //Details display datatable
            $('#example-14').DataTable( {
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_',
                },
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal( {
                            header: function ( row ) {
                                var data = row.data();
                                return 'Details for '+data[0]+' '+data[1];
                            }
                        } ),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                            tableClass: 'table border mb-0'
                        } )
                    }
                }
            } );
            //Details display datatable
            $('#example-15').DataTable( {
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_',
                },
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal( {
                            header: function ( row ) {
                                var data = row.data();
                                return 'Details for '+data[0]+' '+data[1];
                            }
                        } ),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                            tableClass: 'table border mb-0'
                        } )
                    }
                }
            } );
        });
    </script>
@endsection
