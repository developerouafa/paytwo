@extends('Dashboard.layouts.master')
@section('title')
    {{__('Dashboard/main-sidebar_trans.Listofinvoices')}} {{__('Dashboard/services.monetary')}}
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
    <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">{{__('Dashboard/main-sidebar_trans.Listofinvoices')}} {{__('Dashboard/services.monetary')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/main-sidebar_trans.view_all')}}</span>
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
                                <div class="card card-dashboard-eight pb-2">
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

        <div class="row row-sm row-deck">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="card card-dashboard-eight pb-2">
                    <div class="list-group">
                        <div class="list-group-item border-top-0">
                            <h6 class="card-title">{{__('Dashboard/clients_trans.unpaidbill')}}</h6>
                            <span><a href="{{route('Invoices.showinvoicemonetary',$invoice->id)}}">{{__('Dashboard/clients_trans.Modifydata')}}</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-sm">
            <!-- Col -->
            <div class="col-lg-12">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                            <div class="max-w-xl">
                                <div class="card">
                                    <div class="card-body">
                                            <div class="mb-4 main-content-label">{{__('Dashboard/profile.personalinformation')}}</div>

                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">{{__('Dashboard/profile.name')}}</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <h4>{{Auth::user()->name}}</h4>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">{{__('Dashboard/clients_trans.email')}}</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <h4>{{Auth::user()->email}}</h4>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">{{__('Dashboard/profile.clienType')}}</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <h4>
                                                            @if (Auth::user()->profileclient->clienType == 1)
                                                                {{__('Dashboard/users.individual')}}
                                                            @else
                                                                {{__('Dashboard/users.company')}}
                                                            @endif
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>

                                            @if (Auth::user()->profileclient->clienType == '0')
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-label">{{__('Dashboard/profile.commercialRegistrationNumber')}}</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <h4>{{Auth::user()->profileclient->commercialRegistrationNumber}}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">{{__('Dashboard/profile.nationalIdNumber')}}</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <h4>{{Auth::user()->profileclient->nationalIdNumber}}</h4>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">{{__('Dashboard/profile.taxNumber')}}</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <h4>{{Auth::user()->profileclient->taxNumber}}</h4>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">{{__('Dashboard/profile.adderss')}}</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <h4>{{Auth::user()->profileclient->adderss}}</h4>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">{{__('Dashboard/profile.city')}}</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <h4>{{Auth::user()->profileclient->city}}</h4>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">{{__('Dashboard/profile.postalcode')}}</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <h4>{{Auth::user()->profileclient->postalcode}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>

                                @if ($invoice->invoice_status == 2)
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="form-label">
                                                            <b style="color: red"> {{__('Dashboard/clients_trans.selectedpaymentmt')}} </b>
                                                            <b style="color: #03A8E6"> =>
                                                                @if ($invoice->type == "0")
                                                                    {{__('Dashboard/services.noselectionyet')}}
                                                                @elseif ($invoice->type == "1")
                                                                    {{__('Dashboard/services.monetary')}}
                                                                @elseif ($invoice->type == "2")
                                                                    {{__('Dashboard/services.Okay')}}
                                                                @elseif ($invoice->type == "3")
                                                                    {{__('Dashboard/services.Banktransfer')}}
                                                                @elseif ($invoice->type == "4")
                                                                    {{__('Dashboard/services.card')}}
                                                                @endif
                                                            </b>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="form-label">
                                                            <b style="color:darkgreen"> {{__('Dashboard/clients_trans.modifypymethod')}} </b>
                                                            <b style="color: black"> => </b>
                                                            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"  data-toggle="modal" href="#edit{{$invoice->id}}"><i class="las la-pen"></i></a>
                                                            @include('Dashboard.dashboard_client.invoices.modifypymethod')
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($invoice->type == '0')
                                                <div class="row row-sm row-deck">
                                                    <div class="col-md-12 col-lg-12 col-xl-12">
                                                        <div class="card card-dashboard-eight pb-2">
                                                            <div class="list-group">
                                                                <div class="border-top-0" style="text-align: center">
                                                                    <h1 style="color: darkgreen">{{__('Dashboard/clients_trans.pleasechoosepymethod')}}</h1>
                                                                    <span> {{__('Dashboard/services.invoicenumber')}} : #{{$invoice->invoice_number}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($invoice->type == '1')
                                                @if($fund_accountreceipt)
                                                    <form method="post" action="{{ route('Invoice.Confirmpayment') }}" class="mt-6 space-y-6" autocomplete="off" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('patch')

                                                        <div class="row row-sm row-deck">
                                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                                <div class="card card-dashboard-eight pb-2">
                                                                    <div class="list-group">
                                                                        <div class="list-group-item border-top-0">
                                                                            <h6 class="card-title">{{__('Dashboard/clients_trans.hopeattachcpreceipt')}}</h6>
                                                                                <input type="file" name="invoice" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                                                    data-height="100" />
                                                                            <input type="hidden" name="invoice_id" value="{{$invoice->id}}" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex items-center gap-4">
                                                            <div class="card-footer text-left">
                                                                <button type="submit" class="btn btn-primary waves-effect waves-light">{{__('Dashboard/clients_trans.cnpay')}}</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                @else
                                                    <b style="color: #03A8E6"> - {{__('Dashboard/clients_trans.receiptnotsent')}} - {{__('Dashboard/clients_trans.willviantfmail')}}
                                                    => {{__('Dashboard/clients_trans.ifyoupaper')}}</b>
                                                    <br>
                                                    <br>
                                                    <form method="post" action="{{ route('Invoice.Confirmpayment') }}" class="mt-6 space-y-6" autocomplete="off" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('patch')

                                                        <div class="row row-sm row-deck">
                                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                                <div class="card card-dashboard-eight pb-2">
                                                                    <div class="list-group">
                                                                        <div class="list-group-item border-top-0">
                                                                            <h6 class="card-title">{{__('Dashboard/clients_trans.hopeattachcpreceipt')}}</h6>
                                                                                <input type="file" name="invoice" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                                                    data-height="100" />
                                                                            <input type="hidden" name="invoice_id" value="{{$invoice->id}}" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex items-center gap-4">
                                                            <div class="card-footer text-left">
                                                                <button type="submit" class="btn btn-primary waves-effect waves-light">{{__('Dashboard/clients_trans.cnpay')}}</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                @endif
                                            @endif

                                            @if ($invoice->type == '2')
                                                @if($fund_accountpostpaid)
                                                    <form method="post" action="{{ route('Invoice.Confirmpayment') }}" class="mt-6 space-y-6" autocomplete="off" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('patch')

                                                        <div class="row row-sm row-deck">
                                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                                <div class="card card-dashboard-eight pb-2">
                                                                    <div class="list-group">
                                                                        <div class="list-group-item border-top-0">
                                                                            <h6 class="card-title">{{__('Dashboard/clients_trans.hopeattachcpreceipt')}}</h6>
                                                                                <input type="file" name="invoice" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                                                    data-height="100" />
                                                                            <input type="hidden" name="invoice_id" value="{{$invoice->id}}" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex items-center gap-4">
                                                            <div class="card-footer text-left">
                                                                <button type="submit" class="btn btn-primary waves-effect waves-light">{{__('Dashboard/clients_trans.cnpay')}}</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                @else
                                                    <b style="color: #03A8E6"> - {{__('Dashboard/clients_trans.receiptnotsent')}} - {{__('Dashboard/clients_trans.willviantfmail')}}
                                                    => {{__('Dashboard/clients_trans.ifyoupaper')}}</b>
                                                    <br>
                                                    <br>
                                                    <form method="post" action="{{ route('Invoice.Confirmpayment') }}" class="mt-6 space-y-6" autocomplete="off" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('patch')

                                                        <div class="row row-sm row-deck">
                                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                                <div class="card card-dashboard-eight pb-2">
                                                                    <div class="list-group">
                                                                        <div class="list-group-item border-top-0">
                                                                            <h6 class="card-title">{{__('Dashboard/clients_trans.hopeattachcpreceipt')}}</h6>
                                                                                <input type="file" name="invoice" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                                                    data-height="100" />
                                                                            <input type="hidden" name="invoice_id" value="{{$invoice->id}}" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex items-center gap-4">
                                                            <div class="card-footer text-left">
                                                                <button type="submit" class="btn btn-primary waves-effect waves-light">{{__('Dashboard/clients_trans.cnpay')}}</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                @endif
                                            @endif

                                            @if ($invoice->type == '3')
                                                <div class="row row-sm row-deck">
                                                    <div class="col-md-12 col-lg-12 col-xl-12">
                                                        <div class="card card-dashboard-eight pb-2">
                                                            <div class="list-group">
                                                                <div class="border-top-0">
                                                                    <h3>{{__('Dashboard/clients_trans.attachcopytransfer')}}</h3>
                                                                    <b>{{__('Dashboard/clients_trans.transferaccountmediapr')}}</b> <br/>
                                                                    <b> {{__('Dashboard/clients_trans.AlRajhiBank')}} : SA12300000003326665555566</b>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <form method="post" action="{{ route('Invoice.Confirmpayment') }}" class="mt-6 space-y-6" autocomplete="off" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('patch')

                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <input type="text" name="banktransfermade" placeholder="{{__('Dashboard/clients_trans.banktransfermade')}}" class="form-control"><br/>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <input type="file" name="invoice" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png" data-height="100" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="invoice_id" value="{{$invoice->id}}" >

                                                                <div class="flex items-center gap-4">
                                                                    <div class="card-footer text-left">
                                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{__('Dashboard/clients_trans.cnpay')}}</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($invoice->type == '4')
                                                <form action="{{ route('Invoices.confirm') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}" />
                                                        <button type="submit" class="btn btn-purple mt-3">
                                                            <i class="mdi mdi-currency-usd ml-1">{{__('Dashboard/clients_trans.Pay')}}</i>
                                                        </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if ($invoice->invoice_status == 3)
                                    <!-- row opened -->
                                        <div class="row row-sm row-deck">
                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                <div class="card card-dashboard-eight pb-2">
                                                    <div class="list-group">
                                                        <div class="border-top-0" style="text-align: center">
                                                            <h1 style="color: #79CCBC">{{__('Dashboard/services.Under review')}}</h1>
                                                            <span> {{__('Dashboard/services.invoicenumber')}} : #{{$invoice->invoice_number}}</span>
                                                        </div>
                                                        <div style="text-align: center">
                                                            <a href="{{route('Invoices.showinvoice',$invoice->id)}}" class="btn btn-primary waves-effect waves-light">
                                                                {{__('Dashboard/clients_trans.backinvoice')}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- /row -->
                                @endif
                                @if ($invoice->invoice_status == 4)
                                    <!-- row opened -->
                                    <div class="row row-sm row-deck">
                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                            <div class="card card-dashboard-eight pb-2">
                                                <div class="list-group">
                                                    <div class="border-top-0" style="text-align: center">
                                                        <h1 style="color: #79CCBC">{{__('Dashboard/services.Complete')}}</h1>
                                                        <span> {{__('Dashboard/services.invoicenumber')}} : #{{$invoice->invoice_number}}</span>
                                                    </div>
                                                    <div style="text-align: center">
                                                        <a href="{{route('Invoices.showinvoice',$invoice->id)}}" class="btn btn-primary waves-effect waves-light">
                                                            {{__('Dashboard/clients_trans.backinvoice')}}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- /row -->
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Col -->
        </div>
    <!-- row closed -->

			<!-- Container closed -->

		<!-- main-content closed -->
@endsection
@section('js')

    <!--Internal  Chart.bundle js -->
    <script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>

    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>

@endsection
