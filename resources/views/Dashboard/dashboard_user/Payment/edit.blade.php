@extends('Dashboard.layouts.master')
@section('css')
    <!-- Internal Select2 css -->
    <link href="{{URL::asset('dashboard/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('Dashboard/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('title')
    {{__('Dashboard/payment_trans.Amendingpaymentvoucher')}}
@stop
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/payment_trans.theaccounts')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/payment_trans.Amendingpaymentvoucher')}} </span>
            </div>
        </div>
    </div>
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
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('Payment.update', 'test') }}" method="post" autocomplete="off">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <div class="pd-30 pd-sm-40 bg-gray-200">

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <input class="form-control" value="{{$payment_accounts->id}}" name="id" type="hidden">
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label>{{__('Dashboard/payment_trans.price')}}</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <input class="form-control" value="{{$payment_accounts->amount}}" name="credit" type="number">
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label>{{__('Dashboard/payment_trans.descr')}}</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <textarea class="form-control" name="description" rows="3">{{$payment_accounts->description}}</textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-main-primary pd-x-30 mg-r-5 mg-t-5">{{ trans('Dashboard/payment_trans.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    
@endsection
@section('js')

@endsection
