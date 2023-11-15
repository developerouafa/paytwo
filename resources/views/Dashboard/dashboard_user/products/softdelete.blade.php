@extends('Dashboard/layouts.master')
@section('title')
    {{__('Dashboard/main-sidebar_trans.deletedproducts')}}
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
                <h4 class="content-children mb-0 my-auto">{{__('Dashboard/main-sidebar_trans.deletedproducts')}}</h4>
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
        <!-- Index -->
            <div class="col-xl-12">
                <div class="card mg-b-20">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            @can('Delete All Product softdelete')
                                <a class="btn btn-danger" href="{{route('product.deleteallsoftdelete')}}">{{__('Dashboard/messages.Deleteall')}}</a>
                            @endcan

                            @can('Delete Group Product softdelete')
                                <button type="button" class="btn btn-danger" id="btn_delete_all">{{trans('Dashboard/messages.Deletegroup')}}</button>
                            @endcan

                            @can('Restore All Product')
                                <a class="btn btn-info" href="{{route('product.restoreallproducts')}}">{{__('Dashboard/messages.restoreall')}}</a>
                            @endcan

                            @can('Restore Group Product')
                                <button type="button" class="btn btn-info" id="btn_restore_all">{{__('Dashboard/messages.RestoreGroup')}}</button>
                            @endcan
                        </div>
                    </div>
                    @can('Show Product')
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table key-buttons text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            @can('Delete Group Product softdelete')
                                                <th> {{__('Dashboard/messages.Deletegroup')}} <input name="select_all"  id="example-select-all" type="checkbox"/></th>
                                            @endcan
                                            @can('Restore Group Product')
                                                <th> {{__('Dashboard/messages.RestoreGroup')}} <input name="select_allrestore"  id="example-select-all" type="checkbox"/></th>
                                            @endcan
                                            <th>{{__('Dashboard/products.product')}}</th>
                                            <th>{{__('Dashboard/products.description')}}</th>
                                            <th>{{__('Dashboard/products.price')}}</th>
                                            <th>{{__('Dashboard/products.section')}}</th>
                                            <th>{{__('Dashboard/products.children')}}</th>
                                            @can('stock Product')
                                                <th>{{__('Dashboard/products.stock')}}</th>
                                            @endauth
                                            <th>{{__('Dashboard/users.createdbyuser')}}</th>
                                            <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                                            <th>{{__('Dashboard/sections_trans.updated_at')}}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $x)
                                            @if (!empty($x->section_id && $x->parent_id))
                                                @if ($x->section->status == 0)
                                                    @if ($x->subsections->status == 0)
                                                        <tr>
                                                            <td> {{$x->id}} </td>
                                                            @can('Delete Group Product softdelete')
                                                                <td>
                                                                    <input type="checkbox" name="delete_select" value="{{$group_invoice->id}}" class="delete_select">
                                                                </td>
                                                            @endcan
                                                            @can('Restore Group Product')
                                                                <td>
                                                                    <input type="checkbox" name="restore" value="{{$group_invoice->id}}" class="delete_select">
                                                                </td>
                                                            @endcan
                                                            <td> {{$x->name}} </td>
                                                            <td>{{ \Str::limit($x->description, 50) }}</td>
                                                            <td> {{$x->price}}</td>
                                                            <td> {{$x->section->name}} </td>
                                                            <td> {{$x->subsections->name}} </td>
                                                            <td>
                                                                @can('stock Product')
                                                                    @foreach ($stockproduct as $ss)
                                                                        @if ($ss->product_id == $x->id)
                                                                            @if ($ss->stock == "0")
                                                                                {{ __('Dashboard/products.existinstock') }}
                                                                            @endif
                                                                            @if ($ss->stock == "1")
                                                                                {{ __('Dashboard/products.noexistinstock') }}
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                @endcan
                                                            </td>
                                                            <td><a href="#">{{$x->user->name}}</a> </td>
                                                            <td> {{ $x->created_at->diffForHumans() }} </td>
                                                            <td> {{ $x->updated_at->diffForHumans() }} </td>
                                                            <td>
                                                                @can('Restore One Product')
                                                                    <a href="{{route('restorepr', $x->id)}}">{{__('Dashboard/messages.restore')}}</a>
                                                                @endcan
                                                                @can('Delete Product softdelete')
                                                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                                        data-id="{{ $x->id }}" data-name="{{ $x->name }}"
                                                                        data-toggle="modal" href="#modaldemo9" title="Delete">
                                                                        <i class="las la-trash"></i>
                                                                    </a>
                                                                @endcan
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endif
                                            @if (empty($x->parent_id) && !empty($x->section_id))
                                                @if ($x->section->status == 0)
                                                    <tr>
                                                        <td> {{$x->id}} </td>
                                                        @can('Delete Group Product softdelete')
                                                            <td>
                                                                <input type="checkbox" name="delete_select" value="{{$group_invoice->id}}" class="delete_select">
                                                            </td>
                                                        @endcan
                                                        @can('Restore Group Product')
                                                            <td>
                                                                <input type="checkbox" name="restore" value="{{$group_invoice->id}}" class="delete_select">
                                                            </td>
                                                        @endcan
                                                        <td> {{$x->name}} </td>
                                                        <td>{{ \Str::limit($x->description, 50) }}</td>
                                                        <td> {{$x->price}}</td>
                                                        <td> {{$x->section->name}} </td>
                                                        <td> {{__('Dashboard/sections_trans.nochildsection')}} </td>
                                                        <td>
                                                            @foreach ($stockproduct as $ss)
                                                                @if ($ss->product_id == $x->id)
                                                                    @if ($ss->stock == "0")
                                                                        {{ __('Dashboard/products.existinstock') }}
                                                                    @endif
                                                                    @if ($ss->stock == "1")
                                                                        {{ __('Dashboard/products.noexistinstock') }}
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td><a href="#">{{$x->user->name}}</a> </td>
                                                        <td> {{ $x->created_at->diffForHumans() }} </td>
                                                        <td> {{ $x->updated_at->diffForHumans() }} </td>
                                                        <td>
                                                            @can('Restore One Product')
                                                                <a href="{{route('restorepr', $x->id)}}">{{__('Dashboard/messages.restore')}}</a>
                                                            @endcan
                                                            @can('Delete Product softdelete')
                                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                                    data-id="{{ $x->id }}" data-name="{{ $x->name }}"
                                                                    data-toggle="modal" href="#modaldemo9" title="Delete">
                                                                    <i class="las la-trash"></i>
                                                                </a>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            @if (empty($x->section_id))
                                                <tr>
                                                    <td> {{$x->id}} </td>
                                                    @can('Delete Group Product softdelete')
                                                        <td>
                                                            <input type="checkbox" name="delete_select" value="{{$group_invoice->id}}" class="delete_select">
                                                        </td>
                                                    @endcan
                                                    @can('Restore Group Product')
                                                        <td>
                                                            <input type="checkbox" name="restore" value="{{$group_invoice->id}}" class="delete_select">
                                                        </td>
                                                    @endcan
                                                    <td> {{$x->name}} </td>
                                                    <td>{{ \Str::limit($x->description, 50) }}</td>
                                                    <td> {{$x->price}}</td>
                                                    <td> {{__('Dashboard/sections_trans.nosection')}} </td>
                                                    <td> {{__('Dashboard/sections_trans.nochildsection')}} </td>
                                                    <td>
                                                        @foreach ($stockproduct as $ss)
                                                            @if ($ss->product_id == $x->id)
                                                                @if ($ss->stock == "0")
                                                                    {{ __('Dashboard/products.existinstock') }}
                                                                @endif
                                                                @if ($ss->stock == "1")
                                                                    {{ __('Dashboard/products.noexistinstock') }}
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td><a href="#">{{$x->user->name}}</a> </td>
                                                    <td> {{ $x->created_at->diffForHumans() }} </td>
                                                    <td> {{ $x->updated_at->diffForHumans() }} </td>
                                                    <td>
                                                        @can('Restore One Product')
                                                            <a href="{{route('restorepr', $x->id)}}">{{__('Dashboard/messages.restore')}}</a>
                                                        @endcan
                                                        @can('Delete Product softdelete')
                                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                                data-id="{{ $x->id }}" data-name="{{ $x->name }}"
                                                                data-toggle="modal" href="#modaldemo9" title="Delete">
                                                                <i class="las la-trash"></i>
                                                            </a>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endcan
                    @can('Delete Group Product softdelete')
                        @include('Dashboard.dashboard_user.products.delete_selectsoftdelete')
                    @endcan
                    @can('Restore Group Product')
                        @include('Dashboard.dashboard_user.products.restoreall')
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
                        <form action="{{route('product.destroy')}}" method="post">
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
@endsection
@section('js')
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>

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

    <script>
        $(function() {
            jQuery("[name=select_allrestore]").click(function(source) {
                checkboxes = jQuery("[name=restore]");
                for(var i in checkboxes){
                    checkboxes[i].checked = source.target.checked;
                }
            });
        })
    </script>

    <script type="text/javascript">
        $(function () {
            $("#btn_restore_all").click(function () {
                var selected = [];
                $("#example input[name=restore]:checked").each(function () {
                    selected.push(this.value);
                });

                if (selected.length > 0) {
                    $('#restore').modal('show')
                    $('input[id="restore_select_id"]').val(selected);
                }
            });
        });
    </script>
@endsection
