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
        <h1 style="color: blue">{{__('Dashboard/clients_trans.cashpyinvoice')}}</h1>
        <!--div-->
        {{-- <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mg-b-0 text-md-nowrap table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{trans('Dashboard/sections_trans.section')}}</th>
                                    <th>{{trans('Dashboard/products.product')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td>{{$section->name}}</td>
                                        <td>{{ $product->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>{{__('Dashboard/messages.database')}}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div><!-- bd -->
        </div> --}}
        <!--/div-->

        <h1 style="color:darkred">{{__('Dashboard/clients_trans.cashpyinvoicepaid')}}</h1>

        <h1 style="color:darkblue">{{__('Dashboard/clients_trans.banktransferpy')}}</h1>

        <h1 style="color:orangered">{{__('Dashboard/clients_trans.bankcardpy')}}</h1>


    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@endsection
