@extends('Dashboard/layouts.master')
@section('title')
    {{__('Dashboard/sections_trans.childrens')}}
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
                <h4 class="content-children mb-0 my-auto">{{__('Dashboard/sections_trans.childrens')}}</h4>
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

            {{-- <div class="row row-sm"> --}}
                <div class="col-xl-12">
                    <div class="card mg-b-20">
                        @can('Show Children Section')
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table key-buttons text-md-nowrap">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{__('Dashboard/sections_trans.children')}}</th>
                                                <th>{{__('Dashboard/sections_trans.section')}}</th>
                                                <th>{{__('Dashboard/sections_trans.usersection')}}</th>
                                                <th>{{__('Dashboard/sections_trans.userchildren')}}</th>
                                                <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                                                <th>{{__('Dashboard/sections_trans.updated_at')}}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($childrens as $x)
                                                @if ($x->section->status == 0)
                                                    <tr>
                                                        <td>{{$x->id}}</td>
                                                        <td><a href="">{{$x->name}}</a> </td>
                                                        <td>{{$x->section->name}}</td>
                                                        <td>{{$x->section->user->name}}</td>
                                                        <td>{{$x->user->name}}</td>
                                                        <td> {{ $x->created_at->diffForHumans() }} </td>
                                                        <td> {{ $x->updated_at->diffForHumans() }} </td>
                                                        <td>
                                                            <a href="{{route('restorech', $x->id)}}">{{__('Dashboard/messages.restore')}}</a>
                                                            <form action="{{route('forcedeletech', $x->id)}}" method="get">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger">{{__('Dashboard/messages.deletee')}}</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            {{-- </div> --}}

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
@endsection
