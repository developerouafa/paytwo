@extends('Dashboard.layouts.master')
@section('title')
    {{__('Dashboard/main-sidebar_trans.Listofinvoices')}} {{__('Dashboard/services.monetary')}}
@stop
@section('css')

    <style>
        .panel {display: none;}
    </style>

@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/main-sidebar_trans.Listofinvoices')}} {{__('Dashboard/services.monetary')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/main-sidebar_trans.view_all')}}</span>
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
                        <div class="border-top-0" style="text-align: center">
                            <h1 style="color: #79CCBC">{{__('Dashboard/clients_trans.pycmsuccessf')}}</h1>
                            <span> {{__('Dashboard/services.invoicenumber')}} : #{{$invoice->invoice_number}}</span>
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
                        <div class="row row-sm row-deck">
                            <div class="col-md-12 col-lg-12 col-xl-12">
                                <div class="card card-dashboard-eight pb-2">
                                    <div class="list-group">
                                        {{__('Dashboard/clients_trans.taxinvoicemaildwninvoice')}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="text-align: center">
                            <a href="{{route('Invoices.print',$invoice->id)}}" class="btn btn-primary waves-effect waves-light">
                                {{__('Dashboard/clients_trans.backinvoice')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- /row -->

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
