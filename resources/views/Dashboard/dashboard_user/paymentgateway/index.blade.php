@extends('Dashboard.layouts.master')
@section('title')
    {{__('Dashboard/services.card')}}
@stop
@section('css')
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/receipt_trans.theaccounts')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/services.card')}} </span>
            </div>
        </div>
    </div>
@endsection
@section('content')

    <!-- row -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            @can('Delete All Bank Card softdelete')
                                <a class="btn btn-danger" href="{{route('paymentgateway.deleteallpg')}}">{{__('Dashboard/messages.Deleteall')}}</a>
                            @endcan

                            @can('Delete Group Bank Card')
                                <button type="button" class="btn btn-danger" id="btn_delete_all">{{trans('Dashboard/messages.Deletegroup')}}</button>
                            @endcan
                        </div>
                    </div>
                    @can('Show Bank Card')
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table key-buttons text-md-nowrap" data-page-length="50" style="text-align: center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        @can('Delete Group Bank Card')
                                            <th> {{__('Dashboard/messages.DeleteGroup')}} <input name="select_all"  id="example-select-all" type="checkbox"/></th>
                                        @endcan
                                        <th> {{__('Dashboard/services.invoicenumber')}} </th>
                                        <th> {{__('Dashboard/receipt_trans.nameclient')}} </th>
                                        <th> {{__('Dashboard/receipt_trans.price')}} </th>
                                        <th> {{__('Dashboard/receipt_trans.descr')}} </th>
                                        <th>{{__('Dashboard/users.createdbyuser')}}</th>
                                        <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                                        <th>{{__('Dashboard/sections_trans.updated_at')}}</th>
                                        <th> {{__('Dashboard/receipt_trans.Processes')}} </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($fund_accounts as $fund_account)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            @can('Delete Group Bank Card')
                                                <td>
                                                    <input type="checkbox" name="delete_select" value="{{$fund_account->paymentgateway->id}}" class="delete_select">
                                                </td>
                                            @endcan
                                            <td><a href="{{route('Clients.clientinvoice',$fund_account->invoice->id)}}">{{$fund_account->invoice->invoice_number}}</a> </td>
                                            <td><a href="{{route('Clients.showinvoice',$fund_account->paymentgateway->clients->id)}}">{{$fund_account->paymentgateway->clients->name}}</a> </td>
                                            <td>{{ number_format($fund_account->paymentgateway->amount, 2) }}</td>
                                            <td>{{ \Str::limit($fund_account->paymentgateway->description, 50) }}</td>
                                            <td><a href="#">{{$fund_account->paymentgateway->user->name}}</a> </td>
                                            <td> {{ $fund_account->paymentgateway->created_at->diffForHumans() }} </td>
                                            <td> {{ $fund_account->paymentgateway->updated_at->diffForHumans() }} </td>
                                            <td>
                                                @can('Delete Bank Card')
                                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"  data-toggle="modal" href="#delete{{$fund_account->paymentgateway->id}}"><i class="las la-trash"></i></a>
                                                @endcan
                                            </td>
                                        </tr>
                                        @include('Dashboard.dashboard_user.paymentgateway.delete')

                                        @can('Delete Group Bank Card')
                                            @include('Dashboard.dashboard_user.paymentgateway.delete_select')
                                        @endcan

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- bd -->
                    @endcan
                </div><!-- bd -->
            </div>
        </div>
    <!-- row closed -->

@endsection
@section('js')

    <script>
        $(function() {
            jQuery("[name=select_all]").click(function(source) {
                checkboxes = jQuery("[name=delete_select]");
                for(var i in checkboxes){
                    checkboxes[i].checked = source.target.checked;
                }
            });
        })
    </script>

    <script>
        $(function() {
            jQuery("[name=select_all]").click(function(source) {
                checkboxes = jQuery("[name=delete_select]");
                for(var i in checkboxes){
                    checkboxes[i].checked = source.target.checked;
                }
            });
        })
    </script>

    <script type="text/javascript">
        $(function () {
            $("#btn_delete_all").click(function () {
                var selected = [];
                $("#example input[name=delete_select]:checked").each(function () {
                    selected.push(this.value);
                });

                if (selected.length > 0) {
                    $('#delete_select').modal('show')
                    $('input[id="delete_select_id"]').val(selected);
                }
            });
        });
    </script>

    <!--Internal  Notify js -->
    <script src="{{URL::asset('dashboard/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>

@endsection
