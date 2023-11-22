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
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{__('Dashboard/users.Usercontrolpanel')}}
                    <b style="color: blue">{{auth()->user()->name}}</b></h2>
                <p class="mg-b-0">{{__('Dashboard/clients_trans.Salesmonitoringdashb')}}</p>
            </div>
        </div>
        {{-- @can('Header Page Dashboard') --}}
            <div class="main-dashboard-header-right">
                <?php use App\Models\invoice; ?>
                <?php use App\Models\User; ?>
                <?php use App\Models\Client; ?>
                <?php use App\Models\client_account; ?>
                <div>
                    <label class="tx-13">{{__('Dashboard/services.Banktransfer')}}</label>
                    <h5>{{ invoice::where('type', 3)->count()}}</h5>
                </div>
                <div>
                    <label class="tx-13">{{__('Dashboard/services.card')}}</label>
                    <h5>{{ invoice::where('type', 4)->count()}}</h5>
                </div>
                <div>
                    <label class="tx-13">{{__('Dashboard/services.monetary')}}</label>
                    <h5>{{ invoice::where('type', 1)->count()}}</h5>
                </div>
                <div>
                    <label class="tx-13">{{__('Dashboard/payment_trans.Catch payment')}}</label>
                    <h5>{{ invoice::where('type', 2)->count()}}</h5>
                </div>
            </div>
        {{-- @endcan --}}

    </div>
@endsection
@section('content')
    <!-- row -->
        <div class="row row-sm">
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-primary-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">{{__('Dashboard/users.TotalPaymentToday')}}</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                        {{ number_format(client_account::whereDate('created_at', now())->sum('credit')) }}
                                    </h4>
                                    <p class="mb-0 tx-12 text-white op-7">{{__('Dashboard/users.numberpaymenttoday')}}</p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    <i class="fas fa-arrow-circle-up text-white"></i>
                                    <span class="text-white op-7"> +{{client_account::whereDate('created_at', now())->count() }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-success-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">{{__('Dashboard/users.TOTALEARNINGS')}}</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                        {{ number_format(client_account::sum('credit')) }}
                                    </h4>
                                    <p class="mb-0 tx-12 text-white op-7">{{__('Dashboard/users.numbertotalpayment')}}</p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    <i class="fas fa-arrow-circle-up text-white"></i>
                                    <span class="text-white op-7"> +{{ client_account::count() }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-danger-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">{{__('Dashboard/users.completedpaidinvoices')}}</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                        {{ invoice::where('invoice_status', 4)->where('invoice_type', 2)->count() }}
                                    </h4>
                                    <p class="mb-0 tx-12 text-white op-7">{{__('Dashboard/users.numberinvoices')}}</p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    <i class="fas fa-arrow-circle-up text-white"></i>
                                    <span class="text-white op-7">
                                        @php
                                            $invoices = invoice::get();
                                            $count_all= $invoices->count();
                                            $count_invoices = invoice::where('invoice_status', 4)->where('invoice_type', 2)->count();
                                            if($count_invoices == 0){
                                                echo $count_invoices = 0;
                                            }
                                            else{
                                                echo $count_invoices = $count_invoices / $count_all *100 ;
                                            }
                                        @endphp
                                    %</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-warning-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">{{__('Dashboard/users.Canceledpaidinvoices')}}</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                        {{ invoice::where('invoice_status', 4)->where('invoice_type', 3)->count() }}
                                    </h4>
                                    <p class="mb-0 tx-12 text-white op-7">{{__('Dashboard/users.numberofcanceldinvoices')}}</p>
                                </div>
                                <span class="text-white op-7">
                                    @php
                                        $invoices = invoice::get();
                                        $count_all= $invoices->count();
                                        $count_invoices = invoice::where('invoice_status', 4)->where('invoice_type', 3)->count();
                                        if($count_invoices == 0){
                                            echo $count_invoices = 0;
                                        }
                                        else{
                                            echo $count_invoices = $count_invoices / $count_all *100 ;
                                        }
                                    @endphp
                                %</span>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                </div>
            </div>
        </div>
    <!-- row closed -->

    <!-- row opened -->
        <div class="row row-sm">
            <div class="col-md-12 col-lg-12 col-xl-7">
                <div class="card">
                    <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mb-0">Order status</h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                        </div>
                        <p class="tx-12 text-muted mb-0">Order Status and Tracking. Track your order from ship date to arrival. To begin, enter your order number.</p>
                    </div>
                    <div class="card-body">
                        <div class="total-revenue">
                            <div>
                            <h4>120,750</h4>
                            <label><span class="bg-primary"></span>success</label>
                            </div>
                            <div>
                            <h4>56,108</h4>
                            <label><span class="bg-danger"></span>Pending</label>
                            </div>
                            <div>
                            <h4>32,895</h4>
                            <label><span class="bg-warning"></span>Failed</label>
                            </div>
                        </div>
                        <div id="bar" class="sales-bar mt-4"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-xl-5">
                <div class="card card-dashboard-map-one">
                    <label class="main-content-label">Sales Revenue by Customers in USA</label>
                    <span class="d-block mg-b-20 text-muted tx-12">Sales Performance of all states in the United States</span>
                    <div class="">
                        <div class="vmap-wrapper ht-180" id="vmap2"></div>
                    </div>
                </div>
            </div>
        </div>
    <!-- row closed -->

    <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-4 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header pb-1">
                        <h3 class="card-title mb-2">Recent Customers</h3>
                        <p class="tx-12 mb-0 text-muted">A customer is an individual or business that purchases the goods service has evolved to include real-time</p>
                    </div>
                    <div class="card-body p-0 customers mt-1">
                        <div class="list-group list-lg-group list-group-flush">
                            <div class="list-group-item list-group-item-action" href="#">
                                <div class="media mt-0">
                                    <img class="avatar-lg rounded-circle ml-3 my-auto" src="{{URL::asset('assets/img/faces/3.jpg')}}" alt="Image description">
                                    <div class="media-body">
                                        <div class="d-flex align-items-center">
                                            <div class="mt-0">
                                                <h5 class="mb-1 tx-15">Samantha Melon</h5>
                                                <p class="mb-0 tx-13 text-muted">User ID: #1234 <span class="text-success ml-2">Paid</span></p>
                                            </div>
                                            <span class="mr-auto wd-45p fs-16 mt-2">
                                                <div id="spark1" class="wd-100p"></div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item list-group-item-action" href="#">
                                <div class="media mt-0">
                                    <img class="avatar-lg rounded-circle ml-3 my-auto" src="{{URL::asset('assets/img/faces/11.jpg')}}" alt="Image description">
                                    <div class="media-body">
                                        <div class="d-flex align-items-center">
                                            <div class="mt-1">
                                                <h5 class="mb-1 tx-15">Jimmy Changa</h5>
                                                <p class="mb-0 tx-13 text-muted">User ID: #1234 <span class="text-danger ml-2">Pending</span></p>
                                            </div>
                                            <span class="mr-auto wd-45p fs-16 mt-2">
                                                <div id="spark2" class="wd-100p"></div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item list-group-item-action" href="#">
                                <div class="media mt-0">
                                    <img class="avatar-lg rounded-circle ml-3 my-auto" src="{{URL::asset('assets/img/faces/17.jpg')}}" alt="Image description">
                                    <div class="media-body">
                                        <div class="d-flex align-items-center">
                                            <div class="mt-1">
                                                <h5 class="mb-1 tx-15">Gabe Lackmen</h5>
                                                <p class="mb-0 tx-13 text-muted">User ID: #1234<span class="text-danger ml-2">Pending</span></p>
                                            </div>
                                            <span class="mr-auto wd-45p fs-16 mt-2">
                                                <div id="spark3" class="wd-100p"></div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item list-group-item-action" href="#">
                                <div class="media mt-0">
                                    <img class="avatar-lg rounded-circle ml-3 my-auto" src="{{URL::asset('assets/img/faces/15.jpg')}}" alt="Image description">
                                    <div class="media-body">
                                        <div class="d-flex align-items-center">
                                            <div class="mt-1">
                                                <h5 class="mb-1 tx-15">Manuel Labor</h5>
                                                <p class="mb-0 tx-13 text-muted">User ID: #1234<span class="text-success ml-2">Paid</span></p>
                                            </div>
                                            <span class="mr-auto wd-45p fs-16 mt-2">
                                                <div id="spark4" class="wd-100p"></div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item list-group-item-action br-br-7 br-bl-7" href="#">
                                <div class="media mt-0">
                                    <img class="avatar-lg rounded-circle ml-3 my-auto" src="{{URL::asset('assets/img/faces/6.jpg')}}" alt="Image description">
                                    <div class="media-body">
                                        <div class="d-flex align-items-center">
                                            <div class="mt-1">
                                                <h5 class="mb-1 tx-15">Sharon Needles</h5>
                                                <p class="b-0 tx-13 text-muted mb-0">User ID: #1234<span class="text-success ml-2">Paid</span></p>
                                            </div>
                                            <span class="mr-auto wd-45p fs-16 mt-2">
                                                <div id="spark5" class="wd-100p"></div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-header pb-1">
                        <h3 class="card-title mb-2">{{__('Dashboard/users.SalesActivity')}}</h3>
                        <p class="tx-12 mb-0 text-muted">{{__('Dashboard/users.descriptionActivity')}}</p>
                    </div>
                    <div class="product-timeline card-body pt-2 mt-1">
                        <ul class="timeline-1 mb-0">
                            <li class="mt-0"> <i class="ti-pie-chart bg-primary-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">{{__('Dashboard/users.totalproducts')}}</span>
                                <p class="mb-0 text-muted tx-12">
                                    {{ number_format(App\Models\product::count()) }}
                                    {{__('Dashboard/users.NewProducts')}}
                                </p>
                            </li>
                            <li class="mt-0"> <i class="mdi mdi-cart-outline bg-danger-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">{{__('Dashboard/users.TotalSales')}}</span>
                                <p class="mb-0 text-muted tx-12">
                                    {{ number_format(client_account::count()) }}
                                    {{__('Dashboard/users.NewSales')}}</p>
                            </li>
                            <li class="mt-0"> <i class="ti-wallet bg-warning-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">{{__('Dashboard/users.TotalProfit')}}</span>
                                <p class="mb-0 text-muted tx-12">
                                    {{ number_format(client_account::sum('credit')) }}
                                    {{__('Dashboard/users.Newprofit')}}</p>
                            </li>
                            <li class="mt-0"> <i class="ti-bar-chart-alt bg-success-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">{{__('Dashboard/users.invoicesfromcashpayment')}}</span>
                                <p class="mb-0 text-muted tx-12">
                                    {{ number_format(App\Models\invoice::where('type', 1)->count()) +  number_format(App\Models\invoice::where('type', 2)->count())}}
                                    {{__('Dashboard/users.newinvoicesfromcashpayment')}}</p>
                            </li>
                            <li class="mt-0"> <i class="si si-layers bg-purple-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">{{__('Dashboard/users.bankpaymentbills')}}</span>
                                <p class="mb-0 text-muted tx-12">
                                    {{ number_format(App\Models\invoice::where('type', 3)->count()) + number_format(App\Models\invoice::where('type', 4)->count())}}
                                    {{__('Dashboard/users.newbankpamentbills')}}
                                </p>
                            </li>
                            <li class="mt-0"> <i class="la la-sticky-note bg-danger-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">{{__('Dashboard/services.Singleservicebill')}}</span>
                                <p class="mb-0 text-muted tx-12">
                                    {{ number_format(App\Models\invoice::where('invoice_classify', 1)->count())}}
                                    {{__('Dashboard/users.newsingleservicebill')}}
                                </p>
                            </li>
                            <li class="mt-0 mb-0"> <i class="icon-note icons bg-primary-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">{{__('Dashboard/services.Servicepackageinvoice')}}</span>
                                <p class="mb-0 text-muted tx-12">
                                    {{ number_format(App\Models\invoice::where('invoice_classify', 2)->count())}}
                                    {{__('Dashboard/users.newServicepackageinvoice')}}
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-12 col-lg-6">
                <div class="card ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6" style="color: rgb(0, 120, 124)">
                                <div class="d-flex align-items-center pb-2">
                                    <p class="mb-0">{{__('Dashboard/users.totalUseractive')}}</p>
                                </div>
                                <h4 class="font-weight-bold mb-2">
                                    @php
                                        $userslogin = User::get();
                                        $count_alllogin = $userslogin->count();
                                        $count_userslogin = User::where('UserStatus', 1)->count();
                                        if($count_userslogin == 0){
                                            echo 0;
                                        }
                                        else{
                                            echo number_format($count_userslogin / $count_alllogin *100);
                                        }
                                    @endphp
                                %</h4>
                            </div>
                            <div class="col-md-6 mt-4 mt-md-0" style="color:rgb(11, 50, 122)">
                                <div class="d-flex align-items-center pb-2">
                                    <p class="mb-0">{{__('Dashboard/users.activeuserlogin')}}</p>
                                </div>
                                <h4 class="font-weight-bold mb-2">
                                    @php
                                        $users = User::get();
                                        $count_all = $users->count();
                                        $count_users = User::where('Status', 1)->count();
                                        if($count_users == 0){
                                            echo 0;
                                        }
                                        else{
                                            echo number_format($count_users / $count_all *100) ;
                                        }
                                    @endphp
                                %</h4>
                            </div>
                            <div class="col-md-12" style="color:rgb(0, 120, 124)">
                                <div class="d-flex align-items-center pb-2">
                                    <p class="mb-0">{{__('Dashboard/users.profitSingleservicebill')}}</p>
                                </div>
                                <h4 class="font-weight-bold mb-2">
                                    @php
                                        $sum1 = 0;
                                        $invoices = invoice::where('invoice_classify', 1)->get();
                                        foreach($invoices as $invoice){
                                            $clients_account = client_account::where('invoice_id', $invoice->id)->get();
                                            foreach($clients_account as $client_account){
                                                $sum1 += $client_account->credit;
                                            }
                                        }
                                        echo $sum1;
                                    @endphp
                                $</h4>
                            </div>
                            <div class="col-md-12" style="color:rgb(11, 50, 122)">
                                <div class="d-flex align-items-center pb-2">
                                    <p class="mb-0">{{__('Dashboard/users.profitServicepackageinvoice')}}</p>
                                </div>
                                <h4 class="font-weight-bold mb-2">
                                    @php
                                        $sum2 = 0;
                                        $invoices = invoice::where('invoice_classify', 2)->get();
                                        foreach($invoices as $invoice){
                                            $clients_account = client_account::where('invoice_id', $invoice->id)->get();
                                            foreach($clients_account as $client_account){
                                                $sum2 += $client_account->credit;
                                            }
                                        }
                                        echo $sum2;
                                    @endphp
                                $</h4>
                            </div>
                            <div class="col-md-12" style="color:rgb(0, 120, 124)">
                                <div class="d-flex align-items-center pb-2">
                                    <p class="mb-0">{{__('Dashboard/users.invoicesfromcashpayment')}}</p>
                                </div>
                                <h4 class="font-weight-bold mb-2">
                                    @php
                                        $sum3 = 0;
                                        $sum3s = 0;
                                        $invoices = invoice::where('type', 1)->get();
                                        foreach($invoices as $invoice){
                                            $clients_account = client_account::where('invoice_id', $invoice->id)->get();
                                            foreach($clients_account as $client_account){
                                                $sum3 += $client_account->credit;
                                            }
                                        }
                                        $invoicess = invoice::where('type', 2)->get();
                                        foreach($invoicess as $invoice){
                                            $clientss_account = client_account::where('invoice_id', $invoice->id)->get();
                                            foreach($clientss_account as $client_account){
                                                $sum3s += $client_account->credit;
                                            }
                                        }
                                        echo $sum3 + $sum3s;
                                    @endphp
                                $</h4>
                            </div>
                            <div class="col-md-12" style="color:rgb(11, 50, 122)">
                                <div class="d-flex align-items-center pb-2">
                                    <p class="mb-0">{{__('Dashboard/users.bankpaymentbills')}}</p>
                                </div>
                                <h4 class="font-weight-bold mb-2">
                                    @php
                                        $sum4 = 0;
                                        $sum4g = 0;
                                        $invoices = invoice::where('type', 3)->get();
                                        foreach($invoices as $invoice){
                                            $clients_account = client_account::where('invoice_id', $invoice->id)->get();
                                            foreach($clients_account as $client_account){
                                                $sum4 += $client_account->credit;
                                            }
                                        }
                                        $invoicesg = invoice::where('type', 4)->get();
                                        foreach($invoicesg as $invoice){
                                            $clientsg_account = client_account::where('invoice_id', $invoice->id)->get();
                                            foreach($clientsg_account as $client_account){
                                                $sum4 += $client_account->credit;
                                            }
                                        }
                                        echo $sum4 + $sum4g;
                                    @endphp
                                $</h4>
                            </div>
                            <div class="col-md-6" style="color: rgb(0, 120, 124)">
                                <div class="d-flex align-items-center pb-2">
                                    <p class="mb-0">{{__('Dashboard/users.totalClientactive')}}</p>
                                </div>
                                <h4 class="font-weight-bold mb-2">
                                    @php
                                        $clientslogin = Client::get();
                                        $count_alllogin = $clientslogin->count();
                                        $count_clientslogin = Client::where('ClientStatus', 1)->count();
                                        if($count_clientslogin == 0){
                                            echo 0;
                                        }
                                        else{
                                            echo number_format($count_clientslogin / $count_alllogin *100);
                                        }
                                    @endphp
                                %</h4>
                            </div>
                            <div class="col-md-6 mt-4 mt-md-0" style="color:rgb(11, 50, 122)">
                                <div class="d-flex align-items-center pb-2">
                                    <p class="mb-0">{{__('Dashboard/users.activeclientlogin')}}</p>
                                </div>
                                <h4 class="font-weight-bold mb-2">
                                    @php
                                        $clients = Client::get();
                                        $count_all = $clients->count();
                                        $count_clients = Client::where('Status', 1)->count();
                                        if($count_clients == 0){
                                            echo 0;
                                        }
                                        else{
                                            echo number_format($count_clients / $count_all *100) ;
                                        }
                                    @endphp
                                %</h4>
                            </div>
                            <div class="col-md-12" style="color:rgb(0, 120, 124)">
                                <div class="d-flex align-items-center pb-2">
                                    <p class="mb-0">{{__('Dashboard/users.totalclients')}}</p>
                                </div>
                                <h4 class="font-weight-bold mb-2">
                                    @php
                                        $totalclients = Client::count();
                                        echo $totalclients;
                                    @endphp
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- row close -->

    <!-- row opened -->
        <div class="row row-sm row-deck">
            <div class="col-lg-12">
                <div class="card card-table-two">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-1">{{__('Dashboard/users.yourearningyear')}}</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <div class="table-responsive country-table">
                        <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                            <thead>
                                <tr>
                                    <th class="wd-lg-25p">{{__('Dashboard/users.date')}}</th>
                                    <th class="wd-lg-25p tx-right">{{__('Dashboard/users.salescount')}}</th>
                                    <th class="wd-lg-25p tx-right">{{__('Dashboard/users.EARNINGS')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{__('Dashboard/users.firstmonthsyear')}}</td>
                                    <td class="tx-right tx-medium tx-inverse">
                                        {{client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '1')->orWhereMonth('created_at', '=', '2')->orWhereMonth('created_at', '=', '3')->count()}}
                                    </td>
                                    <td class="tx-right tx-medium tx-danger">$
                                        {{client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '1')->orWhereMonth('created_at', '=', '2')->orWhereMonth('created_at', '=', '3')->sum('credit')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{__('Dashboard/users.secondthreemonthsyear')}}</td>
                                    <td class="tx-right tx-medium tx-inverse">
                                        {{client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '4')->orWhereMonth('created_at', '=', '5')->orWhereMonth('created_at', '=', '6')->count()}}
                                    </td>
                                    <td class="tx-right tx-medium tx-danger">$
                                        {{client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '4')->orWhereMonth('created_at', '=', '5')->orWhereMonth('created_at', '=', '6')->sum('credit')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{__('Dashboard/users.monthsthirdyear')}}</td>
                                    <td class="tx-right tx-medium tx-inverse">
                                        {{client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '7')->orWhereMonth('created_at', '=', '8')->orWhereMonth('created_at', '=', '9')->count()}}
                                    </td>
                                    <td class="tx-right tx-medium tx-danger">$
                                        {{client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '7')->orWhereMonth('created_at', '=', '8')->orWhereMonth('created_at', '=', '9')->sum('credit')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{__('Dashboard/users.lastthreemonths')}}</td>
                                    <td class="tx-right tx-medium tx-inverse">
                                        {{client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '10')->orWhereMonth('created_at', '=', '11')->orWhereMonth('created_at', '=', '12')->count()}}
                                    </td>
                                    <td class="tx-right tx-medium tx-danger">$
                                        {{client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '10')->orWhereMonth('created_at', '=', '11')->orWhereMonth('created_at', '=', '12')->sum('credit')}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- /row -->

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
