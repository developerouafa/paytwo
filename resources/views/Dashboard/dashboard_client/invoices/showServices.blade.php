@extends('Dashboard/layouts.master')
@section('title')
    {{__('Dashboard/services.group_services')}}
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    {{__('Dashboard/services.services')}}</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/services.group_services')}}
                </span>
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
            <div class="col-xl-12">
                <div class="card mg-b-20">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table key-buttons text-md-nowrap" data-page-length="50" style="text-align: center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th> {{__('Dashboard/products.product')}} </th>
                                        <th> {{__('Dashboard/services.quantity')}} </th>
                                        <th> {{__('Dashboard/services.nameservice')}} </th>
                                        <th>{{__('Dashboard/services.totalofferincludingtax')}}</th>
                                        <th>{{__('Dashboard/services.description')}}</th>
                                        <th>{{__('Dashboard/users.createdbyuser')}}</th>
                                        <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                                        <th>{{__('Dashboard/sections_trans.updated_at')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product_group as $group)
                                        <tr>
                                            <td>{{ $loop->iteration}}</td>
                                            <td>
                                                <a href="{{route('Invoices.showService', $group->product->id)}}">{{ $group->product->name }}</a>
                                            </td>
                                            <td>{{ $group->quantity }}</td>
                                            <td>{{ $group->groupprodcut->name }}</td>
                                            <td>{{ number_format($group->groupprodcut->Total_with_tax, 2) }}</td>
                                            <td>{{ \Str::limit($group->groupprodcut->notes, 50) }}</td>
                                            <td>{{$group->groupprodcut->user->name}}</td>
                                            <td> {{ $group->groupprodcut->created_at->diffForHumans() }} </td>
                                            <td> {{ $group->groupprodcut->updated_at->diffForHumans() }} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                        <form action="{{route('GroupServices.destroy')}}" method="post">
                            {{ method_field('delete') }}
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <p>{{__('Dashboard/products.aresuredeleting')}}</p><br>
                                <input type="hidden" name="id" id="id">
                                <input type="hidden" value="1" name="page_id">
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

@endsection
@section('js')
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>

@endsection
