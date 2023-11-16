@extends('Dashboard/layouts.master')
@section('title')
    {{__('Dashboard/products.images')}}
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
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/products.images')}}</h4>
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
                                        <th>{{__('Dashboard/products.mainimage')}}</th>
                                        <th>{{__('Dashboard/products.galleryimages')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td>{{$Product->id}}</td>
                                            <td>{{$Product->name}}</td>
                                            @forelse ($mainimage as $x)
                                                <td>
                                                    <img src="{{asset('storage/'.$x->mainimage)}}" alt="" style="width: 80px; height:80px;">
                                                    <br>
                                                </td>
                                            @empty
                                                <td> <b> {{__('Dashboard/products.noimage')}} </b> </td>
                                            @endforelse
                                            @forelse ($multimg as $x)
                                                <td>
                                                    <img src="{{asset('storage/'.$x->multipimage)}}" alt="" style="width: 80px; height:80px;">
                                                    <br>
                                                </td>
                                            @empty
                                                <td> <b> {{__('Dashboard/products.noimage')}} </b> </td>
                                            @endforelse
                                        </tr>
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
