@extends('Dashboard.layouts.master')
@section('css')
    <!-- Internal Select2 css -->
    <link href="{{URL::asset('dashboard/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('Dashboard/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('title')
    {{__('Dashboard/receipt_trans.addreceipt')}}
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/receipt_trans.theaccounts')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/receipt_trans.addreceipt')}}</span>
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
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('Receipt.index') }}">{{__('Dashboard/messages.back')}}</a>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('Receipt.storerc') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="pd-30 pd-sm-40 bg-gray-200">
                            <div class="row row-xs align-items-center mg-b-20">
                                <input type="hidden" name="invoice_id" value="{{$invoice_id}}">
                                <input type="hidden" name="client_id" value="{{ $client_id }}" />
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label>{{__('Dashboard/receipt_trans.price')}}</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    {{-- <input class="form-control" name="Debit" type="number"> --}}
                                    <input class="form-control" name="Debit" type="text" value="{{$invoice->total_with_tax}}">
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label>{{__('Dashboard/receipt_trans.descr')}}</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <textarea class="form-control" name="description" rows="3"></textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-main-primary pd-x-30 mg-r-5 mg-t-5">{{ trans('Dashboard/receipt_trans.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Notify js -->
    <script src="{{URL::asset('dashboard/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>
@endsection
