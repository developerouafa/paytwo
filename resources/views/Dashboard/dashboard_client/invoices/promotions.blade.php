@extends('Dashboard/layouts.master')
@section('title')
    {{__('Dashboard/products.promotion')}}
@endsection
@section('css')

@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/products.promotion')}}</h4>
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
                                            <th>{{__('Dashboard/products.products')}}</th>
                                            <th>{{__('Dashboard/products.start_time')}}</th>
                                            <th>{{__('Dashboard/products.end_time')}}</th>
                                            <th>{{__('Dashboard/products.products')}}</th>
                                            <th>{{__('Dashboard/users.createdbyuser')}}</th>
                                            <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                                            <th>{{__('Dashboard/sections_trans.updated_at')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($promotion as $x)
                                            <tr>
                                                <td>{{$x->id}}</td>
                                                <td><a>{{$product->name}}</a></td>
                                                <td><a>{{$x->start_time}}</a></td>
                                                <td><a>{{$x->end_time}}</a></td>
                                                <td><a>{{$x->price}}</a></td>
                                                <td><a href="#">{{$x->user->name}}</a> </td>
                                                <td> {{ $x->created_at->diffForHumans() }} </td>
                                                <td> {{ $x->updated_at->diffForHumans() }} </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
