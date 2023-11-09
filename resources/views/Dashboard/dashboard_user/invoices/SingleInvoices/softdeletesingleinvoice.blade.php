@extends('Dashboard/layouts.master')
@section('title')
    {{__('Dashboard/main-sidebar_trans.deletedSingleservicebill')}}
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> {{__('Dashboard/services.invoices')}} </h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/      {{__('Dashboard/services.deletedSingleservicebill')}} </span>
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

        <!-- Index -->
            <div class="col-xl-12">
                <div class="card mg-b-20">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            @can('Delete All SingleInvoice softdelete')
                                <a class="btn btn-danger" href="{{route('SingleInvoices.deleteallsingleinvoice')}}">{{__('Dashboard/messages.Deleteall')}}</a>
                            @endcan

                            @can('Delete Group SingleInvoice softdelete')
                                <button type="button" class="btn btn-danger" id="btn_delete_all">{{trans('Dashboard/messages.Deletegroup')}}</button>
                            @endcan
                        </div>
                    </div>
                    @can('Show Single Invoices softdelete')
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table key-buttons text-md-nowrap" data-page-length="50" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            @can('Delete Group SingleInvoice softdelete')
                                                <th><input name="select_all"  id="example-select-all" type="checkbox"/></th>
                                            @endcan
                                            <th> {{__('Dashboard/services.print')}} </th>
                                            <th> {{__('Dashboard/services.invoicenumber')}} </th>
                                            <th> {{__('Dashboard/services.nameservice')}} </th>
                                            <th> {{__('Dashboard/services.client')}} </th>
                                            <th> {{__('Dashboard/services.dateinvoice')}} </th>
                                            <th> {{__('Dashboard/services.priceservice')}} </th>
                                            <th> {{__('Dashboard/services.discountvalue')}} </th>
                                            <th> {{__('Dashboard/services.Taxrate')}} </th>
                                            <th> {{__('Dashboard/services.Taxvalue')}} </th>
                                            <th> {{__('Dashboard/services.Totalwithtax')}} </th>
                                            <th> {{__('Dashboard/services.type')}} </th>
                                            <th> {{__('Dashboard/services.Invoicestatus')}} </th>
                                            <th> {{__('Dashboard/services.Invoicetype')}} </th>
                                            <th> {{__('Dashboard/users.createdbyuser')}} </th>
                                            <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                                            <th>{{__('Dashboard/sections_trans.updated_at')}}</th>
                                            <th> {{__('Dashboard/services.Processes')}} </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($single_invoices as $single_invoice)
                                            <tr>
                                                <td>{{ $loop->iteration}}</td>
                                                @can('Delete Group SingleInvoice softdelete')
                                                    <td>
                                                        <input type="checkbox" name="delete_select" value="{{$single_invoice->id}}" class="delete_select">
                                                    </td>
                                                @endcan
                                                <td>
                                                    <a href="{{route('Clients.clientinvoice', $single_invoice->id)}}" class="btn btn-primary btn-sm" target="_blank">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $single_invoice->invoice_number }}</td>
                                                <td>
                                                    <a href="{{route('Product.show', $single_invoice->Service->id)}}">{{ $single_invoice->Service->name }}</a>
                                                </td>
                                                <td>
                                                    <a href="{{route('Clients.showinvoice',$single_invoice->client->id)}}">{{$single_invoice->client->name}}</a>
                                                </td>
                                                <td>{{ $single_invoice->invoice_date }}</td>
                                                <td>{{ number_format($single_invoice->price, 2) }}</td>
                                                <td>{{ number_format($single_invoice->discount_value, 2) }}</td>
                                                <td>{{ $single_invoice->tax_rate }}%</td>
                                                <td>{{ number_format($single_invoice->tax_value, 2) }}</td>
                                                <td>{{ number_format($single_invoice->total_with_tax, 2) }}</td>
                                                <td>
                                                    @if ($single_invoice->type == 1)
                                                        {{__('Dashboard/services.monetary')}}
                                                    @elseif ($single_invoice->type == 0)
                                                        {{__('Dashboard/services.noselectionyet')}}
                                                    @elseif ($single_invoice->type == 2)
                                                        {{__('Dashboard/services.Okay')}}
                                                    @elseif ($single_invoice->type == 3)
                                                        {{__('Dashboard/services.Banktransfer')}}
                                                    @elseif ($single_invoice->type == 4)
                                                        {{__('Dashboard/services.card')}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($single_invoice->invoice_status == 1)
                                                        {{__('Dashboard/services.New')}}
                                                        <a href="{{route('invoicestatus', $single_invoice->id)}}">{{__('Dashboard/services.Sent')}}</a>
                                                    @elseif ($single_invoice->invoice_status == 2)
                                                        {{__('Dashboard/services.Sent')}}
                                                    @elseif ($single_invoice->invoice_status == 3)
                                                        {{__('Dashboard/services.Under review')}}
                                                    @elseif ($single_invoice->invoice_status == 4)
                                                        {{__('Dashboard/services.Complete')}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($single_invoice->invoice_type == 1)
                                                        {{__('Dashboard/services.Draft')}}
                                                    @elseif ($single_invoice->invoice_type == 2)
                                                        {{__('Dashboard/services.Paid')}}
                                                    @elseif ($single_invoice->invoice_type == 3)
                                                        {{__('Dashboard/services.Canceled')}}
                                                    @endif
                                                </td>
                                                <td>{{$single_invoice->user->name}}</td>
                                                <td> {{ $single_invoice->created_at->diffForHumans() }} </td>
                                                <td> {{ $single_invoice->updated_at->diffForHumans() }} </td>
                                                <td>
                                                    @can('Delete Single Invoices softdelete')
                                                    <a href="{{route('SingleInvoices.restoresingleinvoice', $single_invoice->id)}}">{{__('Dashboard/messages.restore')}}</a>
                                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                            data-id="{{ $single_invoice->id }}" data-name="{{ $single_invoice->invoice_number }}"
                                                            data-toggle="modal" href="#modaldemo9" title="Delete">
                                                            <i class="las la-trash"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endcan
                    @can('Delete Group SingleInvoice softdelete')
                        @include('Dashboard.dashboard_user.invoices.Singleinvoices.delete_selectsingleinvoicesoftdelete')
                    @endcan
                </div>
            </div>

        <!-- delete -->
            <div class="modal" id="modaldemo9">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title">{{__('Dashboard/products.delete')}}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form action="{{route('SingleInvoices.destroysingleinvoice')}}" method="post">
                            {{ method_field('delete') }}
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <p>{{__('Dashboard/products.aresuredeleting')}}</p><br>
                                <input type="hidden" name="id" id="id">
                                <input type="hidden" value="3" name="page_id">
                                <input class="form-control" name="name" id="name" type="text" readonly>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Dashboard/products.Close')}}</button>
                                <button type="submit" class="btn btn-danger">{{__('Dashboard/products.delete')}}</button>
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
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
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
@endsection
