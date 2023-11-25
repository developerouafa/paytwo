@extends('Dashboard.layouts.master')
@section('title')
    {{__('Dashboard/main-sidebar_trans.invoice')}}
@stop
@section('css')

    <style>
        .panel {display: none;}
    </style>

    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">

@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/main-sidebar_trans.invoice')}} </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/main-sidebar_trans.view_all')}}</span>
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

    <!-- row opened -->
        <div class="row row-sm row-deck">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="card card-dashboard-eight pb-2">
                    <div class="list-group">
                        <div class="list-group-item border-top-0">
                            <h6 class="card-title">{{__('Dashboard/clients_trans.unpaidbill')}}</h6>
                            <span>#{{$invoice->invoice_number}}</span>
                        </div>
                        <div class="row row-sm row-deck">
                            <div class="col-md-12 col-lg-12 col-xl-12">
                                <div class="card card-dashboard-eight pb-2" style="border-color: #79CCBC">
                                    <div class="list-group">
                                        <div class="list-group-item border-top-0">
                                            <h6>{{__('Dashboard/clients_trans.goldenpk')}}</h6>
                                            <span>{{$invoice->price}}</span>
                                        </div>
                                        <div class="list-group-item border-top-0">
                                            <h6>{{__('Dashboard/clients_trans.Valuetax')}}</h6>
                                            <span>{{$invoice->tax_value}}</span>
                                        </div>
                                        <hr>
                                        <div class="list-group-item border-top-0">
                                            <h6>{{__('Dashboard/clients_trans.Total')}}</h6>
                                            <span>{{$invoice->total_with_tax}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- /row -->

        <h4>{{__('Dashboard/clients_trans.completeinfablepay')}}</h4>

    <!-- row -->
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                            <div class="max-w-xl">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" action="{{ route('Invoice.Complete') }}" class="mt-6 space-y-6" autocomplete="off">
                                            @csrf
                                            @method('patch')
                                            <div class="mb-4 main-content-label">{{__('Dashboard/profile.personalinformation')}}</div>

                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">{{__('Dashboard/profile.name')}}</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" name="name" class="form-control" value="{{Auth::user()->name}}"  autofocus autocomplete="name" >
                                                            <x-input-error class="mt-2" style="color: red" :messages="$errors->get('name')" />
                                                            <input type="hidden" name="profileclientid" value="{{Auth::user()->profileclient->id}}">
                                                            <input type="hidden" name="client_id" value="{{Auth::user()->profileclient->client_id}}">
                                                            <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">{{__('Dashboard/clients_trans.email')}}</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" name="email" class="form-control" value="{{Auth::user()->email}}" autofocus autocomplete="email" >
                                                            <x-input-error class="mt-2" style="color: red" :messages="$errors->get('email')" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">{{__('Dashboard/profile.clienType')}}</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <select name="clienType" class="form-control nice-select custom-select" id="sectionChooser">
                                                                <option disabled> {{__('Dashboard/services.Choosefromthelist')}} </option>
                                                                <option value="1">{{__('Dashboard/users.individual')}}</option>
                                                                <option value="0">{{__('Dashboard/users.company')}}</option>
                                                            </select>
                                                            <x-input-error class="mt-2" style="color: red" :messages="$errors->get('clienType')" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="panel" id="0">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="form-label">{{__('Dashboard/profile.commercialRegistrationNumber')}}</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input type="text" name="commercialRegistrationNumber" class="form-control" value="{{Auth::user()->profileclient->commercialRegistrationNumber}}" autofocus autocomplete="commercialRegistrationNumber" >
                                                                <x-input-error class="mt-2" style="color: red" :messages="$errors->get('commercialRegistrationNumber')" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">{{__('Dashboard/profile.nationalIdNumber')}}</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" name="nationalIdNumber" class="form-control" value="{{Auth::user()->profileclient->nationalIdNumber}}" autofocus autocomplete="nationalIdNumber" >
                                                            <x-input-error class="mt-2" style="color: red" :messages="$errors->get('nationalIdNumber')" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">{{__('Dashboard/profile.taxNumber')}}</label>
                                                            <input type="checkbox" name="nothavetax">{{__('Dashboard/clients_trans.nothavetax')}}
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" name="taxNumber" class="form-control" value="{{Auth::user()->profileclient->taxNumber}}" autofocus autocomplete="taxNumber" >
                                                            <x-input-error class="mt-2" style="color: red" :messages="$errors->get('taxNumber')" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">{{__('Dashboard/profile.adderss')}}</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="address" name="address" class="form-control" value="{{Auth::user()->profileclient->adderss}}" autofocus autocomplete="address" >
                                                            <x-input-error class="mt-2" style="color: red" :messages="$errors->get('address')"  autocomplete="address"/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">{{__('Dashboard/profile.city')}}</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" name="city" class="form-control" value="{{Auth::user()->profileclient->city}}" autofocus autocomplete="city" >
                                                            <x-input-error class="mt-2" style="color: red" :messages="$errors->get('city')" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">{{__('Dashboard/profile.postalcode')}}</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="number" name="postalcode" class="form-control" value="{{Auth::user()->profileclient->postalcode}}" autofocus autocomplete="postalcode" >
                                                            <x-input-error class="mt-2" style="color: red" :messages="$errors->get('postalcode')" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex items-center gap-4">
                                                    <div class="card-footer text-left">
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{__('Dashboard/clients_trans.saveandcnpay')}}</button>
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- row closed -->

@endsection
@section('js')

    <script>
        $('#sectionChooser').change(function(){
            var myID = $(this).val();
            $('.panel').each(function(){
                myID === $(this).attr('id') ? $(this).show() : $(this).hide();
            });
        });
    </script>

    <!-- Internal Select2.min js -->
        <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
        <script src="{{URL::asset('assets/js/select2.js')}}"></script>

@endsection
