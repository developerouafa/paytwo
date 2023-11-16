<!-- Sidebar-right-->
    <div class="sidebar sidebar-left sidebar-animate">
        <div class="panel panel-primary card mb-0 box-shadow">
            <div class="tab-menu-heading border-0 p-3">
                <div class="card-title mb-0">{{__('Dashboard/main-sidebar_trans.Notifications')}}</div>
                <div class="card-options mr-auto">
                    <a href="#" class="sidebar-remove"><i class="fe fe-x"></i></a>
                </div>
            </div>
            <div class="panel-body tabs-menu-body latest-tasks p-0 border-0">
                <div class="tabs-menu ">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li>
                            <a href="#side2" class="active" data-toggle="tab">
                                <i class="ion ion-md-notifications tx-18  ml-2"></i>
                                {{__('Dashboard/main-sidebar_trans.Notifications')}}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="side2" id="unreadNotifications">
                        @forelse (auth()->user()->unreadNotifications as $notification)
                        @if ($notification->type == 'App\Notifications\invoicent')
                            <a class="d-flex p-3 border-bottom" href="{{route('Invoices.showinvoicent',$notification->data['invoice_id'])}}">
                                <div class="notifyimg bg-pink">
                                    <i class="mdi mdi-currency-usd ml-1"></i>
                                </div>
                                <div class="mr-2 ml-2">
                                    <h5 class="notification-label mb-1">{{$notification->data['message']}}</h5>
                                    <div class="notification-subtext">{{$notification->created_at->diffForHumans()}}</div>
                                </div>
                                <div class="mr-auto">
                                    <i class="las la-angle-left text-left text-muted"></i>
                                </div>
                            </a>
                        @endif
                        @if ($notification->type == 'App\Notifications\montaryinvoice')
                            <a class="d-flex p-3 border-bottom" href="{{route('Invoices.showinvoicent',$notification->data['invoice_id'])}}">
                                <div class="notifyimg bg-pink">
                                    <i class="mdi mdi-currency-usd ml-1"></i>
                                </div>
                                <div class="mr-2 ml-2">
                                    <h5 class="notification-label mb-1">{{$notification->data['message']}}</h5>
                                    <div class="notification-subtext">{{$notification->created_at->diffForHumans()}}</div>
                                </div>
                                <div class="mr-auto">
                                    <i class="las la-angle-left text-left text-muted"></i>
                                </div>
                            </a>
                        @endif
                        @if ($notification->type == 'App\Notifications\postpaidbillinvoice')
                            <a class="d-flex p-3 border-bottom" href="{{route('Invoices.showinvoicent',$notification->data['invoice_id'])}}">
                                <div class="notifyimg bg-success">
                                    <i class="mdi mdi-currency-usd ml-1"></i>
                                </div>
                                <div class="mr-2 ml-2">
                                    <h5 class="notification-label mb-1">{{$notification->data['message']}}</h5>
                                    <div class="notification-subtext">{{$notification->created_at->diffForHumans()}}</div>
                                </div>
                                <div class="mr-auto">
                                    <i class="las la-angle-left text-left text-muted"></i>
                                </div>
                            </a>
                        @endif
                        @if ($notification->type == 'App\Notifications\paymentgateways')
                            <a class="d-flex p-3 border-bottom" href="{{route('Invoices.showinvoicent',$notification->data['invoice_id'])}}">
                                <div class="notifyimg bg-purple">
                                    <i class="mdi mdi-currency-usd ml-1"></i>
                                </div>
                                <div class="mr-2 ml-2">
                                    <h5 class="notification-label mb-1">{{$notification->data['message']}}</h5>
                                    <div class="notification-subtext">{{$notification->created_at->diffForHumans()}}</div>
                                </div>
                                <div class="mr-auto">
                                    <i class="las la-angle-left text-left text-muted"></i>
                                </div>
                            </a>
                        @endif
                        @if ($notification->type == 'App\Notifications\banktransferntf')
                            <a class="d-flex p-3 border-bottom" href="{{route('Invoices.showinvoicent',$notification->data['invoice_id'])}}">
                                <div class="notifyimg bg-primary">
                                    <i class="mdi mdi-currency-usd ml-1"></i>
                                </div>
                                <div class="mr-2 ml-2">
                                    <h5 class="notification-label mb-1">{{$notification->data['message']}}</h5>
                                    <div class="notification-subtext">{{$notification->created_at->diffForHumans()}}</div>
                                </div>
                                <div class="mr-auto">
                                    <i class="las la-angle-left text-left text-muted"></i>
                                </div>
                            </a>
                        @endif
                        @if ($notification->type == 'App\Notifications\catchreceipt')
                            <a class="d-flex p-3 border-bottom" href="{{route('Invoices.showinvoicereceiptnt',$notification->data['invoice_id'])}}">
                                <div class="notifyimg bg-warning">
                                    <i class="mdi mdi-currency-usd ml-1"></i>
                                </div>
                                <div class="mr-2 ml-2">
                                    <h5 class="notification-label mb-1">{{$notification->data['message']}}</h5>
                                    <div class="notification-subtext">{{$notification->created_at->diffForHumans()}}</div>
                                </div>
                                <div class="mr-auto">
                                    <i class="las la-angle-left text-left text-muted"></i>
                                </div>
                            </a>
                        @endif
                        @if ($notification->type == 'App\Notifications\catchpayment')
                            <a class="d-flex p-3 border-bottom" href="{{route('Invoices.showinvoicereceiptPostpaidnt',$notification->data['invoice_id'])}}">
                                <div class="notifyimg bg-danger">
                                    <i class="mdi mdi-currency-usd ml-1"></i>
                                </div>
                                <div class="mr-2 ml-2">
                                    <h5 class="notification-label mb-1">{{$notification->data['message']}}</h5>
                                    <div class="notification-subtext">{{$notification->created_at->diffForHumans()}}</div>
                                </div>
                                <div class="mr-auto">
                                    <i class="las la-angle-left text-left text-muted"></i>
                                </div>
                            </a>
                        @endif
                        @empty
                            {{__('Dashboard/main-header_trans.thereareno')}}
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--/Sidebar-right-->
