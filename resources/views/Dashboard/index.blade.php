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
                            <div class="col-md-6" style="color: rgb(153, 10, 10)">
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
                            <div class="col-md-6 mt-4 mt-md-0" style="color:brown">
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
                                        $sum = 0;
                                        $invoices = invoice::where('invoice_classify', 1)->get();
                                        foreach($invoices as $invoice){
                                            $clients_account = client_account::where('invoice_id', $invoice->id)->get();
                                            foreach($clients_account as $client_account){
                                                $sum += $client_account->credit;
                                            }
                                        }
                                        echo $sum;
                                    @endphp
                                $</h4>
                            </div>
                            <div class="col-md-12" style="color:rgb(11, 50, 122)">
                                <div class="d-flex align-items-center pb-2">
                                    <p class="mb-0">{{__('Dashboard/users.profitServicepackageinvoice')}}</p>
                                </div>
                                <h4 class="font-weight-bold mb-2">
                                    @php
                                        $sum = 0;
                                        $invoices = invoice::where('invoice_classify', 2)->get();
                                        foreach($invoices as $invoice){
                                            $clients_account = client_account::where('invoice_id', $invoice->id)->get();
                                            foreach($clients_account as $client_account){
                                                $sum += $client_account->credit;
                                            }
                                        }
                                        echo $sum;
                                    @endphp
                                $</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- row close -->

    <!-- row opened -->
        <div class="row row-sm row-deck">
            <div class="col-md-12 col-lg-4 col-xl-4">
                <div class="card card-dashboard-eight pb-2">
                    <h6 class="card-title">Your Top Countries</h6><span class="d-block mg-b-10 text-muted tx-12">Sales performance revenue based by country</span>
                    <div class="list-group">
                        <div class="list-group-item border-top-0">
                            <i class="flag-icon flag-icon-us flag-icon-squared"></i>
                            <p>United States</p><span>$1,671.10</span>
                        </div>
                        <div class="list-group-item">
                            <i class="flag-icon flag-icon-nl flag-icon-squared"></i>
                            <p>Netherlands</p><span>$1,064.75</span>
                        </div>
                        <div class="list-group-item">
                            <i class="flag-icon flag-icon-gb flag-icon-squared"></i>
                            <p>United Kingdom</p><span>$1,055.98</span>
                        </div>
                        <div class="list-group-item">
                            <i class="flag-icon flag-icon-ca flag-icon-squared"></i>
                            <p>Canada</p><span>$1,045.49</span>
                        </div>
                        <div class="list-group-item">
                            <i class="flag-icon flag-icon-in flag-icon-squared"></i>
                            <p>India</p><span>$1,930.12</span>
                        </div>
                        <div class="list-group-item border-bottom-0 mb-0">
                            <i class="flag-icon flag-icon-au flag-icon-squared"></i>
                            <p>Australia</p><span>$1,042.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-8 col-xl-8">
                <div class="card card-table-two">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-1">Your Most Recent Earnings</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <span class="tx-12 tx-muted mb-3 ">This is your most recent earnings for today's date.</span>
                    <div class="table-responsive country-table">
                        <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                            <thead>
                                <tr>
                                    <th class="wd-lg-25p">Date</th>
                                    <th class="wd-lg-25p tx-right">Sales Count</th>
                                    <th class="wd-lg-25p tx-right">Earnings</th>
                                    <th class="wd-lg-25p tx-right">Tax Witheld</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>05 Dec 2019</td>
                                    <td class="tx-right tx-medium tx-inverse">34</td>
                                    <td class="tx-right tx-medium tx-inverse">$658.20</td>
                                    <td class="tx-right tx-medium tx-danger">-$45.10</td>
                                </tr>
                                <tr>
                                    <td>06 Dec 2019</td>
                                    <td class="tx-right tx-medium tx-inverse">26</td>
                                    <td class="tx-right tx-medium tx-inverse">$453.25</td>
                                    <td class="tx-right tx-medium tx-danger">-$15.02</td>
                                </tr>
                                <tr>
                                    <td>07 Dec 2019</td>
                                    <td class="tx-right tx-medium tx-inverse">34</td>
                                    <td class="tx-right tx-medium tx-inverse">$653.12</td>
                                    <td class="tx-right tx-medium tx-danger">-$13.45</td>
                                </tr>
                                <tr>
                                    <td>08 Dec 2019</td>
                                    <td class="tx-right tx-medium tx-inverse">45</td>
                                    <td class="tx-right tx-medium tx-inverse">$546.47</td>
                                    <td class="tx-right tx-medium tx-danger">-$24.22</td>
                                </tr>
                                <tr>
                                    <td>09 Dec 2019</td>
                                    <td class="tx-right tx-medium tx-inverse">31</td>
                                    <td class="tx-right tx-medium tx-inverse">$425.72</td>
                                    <td class="tx-right tx-medium tx-danger">-$25.01</td>
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
