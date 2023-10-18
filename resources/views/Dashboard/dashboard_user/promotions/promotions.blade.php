@extends('Dashboard/layouts.master')
@section('title')
    {{__('Dashboard/products.promotion')}}
@endsection
@section('css')

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/products.promotion')}}</h4>
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
            {{-- Index --}}
            <div class="col-xl-12">
                <div class="card mg-b-20">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-danger" href="{{route('promotions.deleteall')}}">{{__('Dashboard/messages.Deleteall')}}</a>
                            <button type="button" class="btn btn-danger" id="btn_delete_all">{{trans('Dashboard/messages.Deletegroup')}}</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table key-buttons text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><input name="select_all"  id="example-select-all" type="checkbox"/></th>
                                        <th>{{__('Dashboard/products.products')}}</th>
                                        <th>{{__('Dashboard/products.start_time')}}</th>
                                        <th>{{__('Dashboard/products.end_time')}}</th>
                                        <th>{{__('Dashboard/products.products')}}</th>
                                        <th>{{__('Dashboard/products.expired')}}</th>
                                        <th>{{__('Dashboard/users.createdbyuser')}}</th>
                                        <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                                        <th>{{__('Dashboard/sections_trans.updated_at')}}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($promotion as $x)
                                        <tr>
                                            <td>{{$x->id}}</td>
                                            <td>
                                                <input type="checkbox" name="delete_select" value="{{$x->id}}" class="delete_select">
                                            </td>
                                            <td><a>{{$product->name}}</a></td>
                                            <td><a>{{$x->start_time}}</a></td>
                                            <td><a>{{$x->end_time}}</a></td>
                                            <td><a>{{$x->price}}</a></td>
                                            <td>
                                                @if ($x->expired == 1)
                                                    <a href="{{route('promotions.editstatusactive', $x->id)}}">{{__('Dashboard/products.disabled')}}</a>
                                                @endif
                                                @if ($x->expired == 0)
                                                    <a href="{{route('promotions.editstatusdéactive', $x->id)}}">{{__('Dashboard/products.active')}}</a>
                                                @endif
                                            </td>
                                            <td><a href="#">{{$x->user->name}}</a> </td>
                                            <td> {{ $x->created_at->diffForHumans() }} </td>
                                            <td> {{ $x->updated_at->diffForHumans() }} </td>
                                            <td>
                                                <a class="modal-effect btn btn-sm btn-success" data-effect="effect-scale"
                                                    data-id="{{ $x->id }}" data-start_time="{{ $x->start_time }}" data-end_time="{{ $x->end_time }}" data-price="{{ $x->price }}" data-toggle="modal"
                                                    href="#exampleModal2" title="Update">
                                                    <i class="las la-pen"></i>
                                                    {{__('Dashboard/products.updatepromotion')}}
                                                </a>
                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-id="{{ $x->id }}" data-price="{{ $x->price }}" data-toggle="modal"
                                                    href="#modaldemo9" title="Delete">
                                                    {{__('Dashboard/products.deletepromotion')}}
                                                </a>
                                            </td>
                                        </tr>
                                        @include('Dashboard.dashboard_user.promotions.delete_select')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- edit -->
            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{__('Dashboard/products.updatepromotion')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('promotions.update')}}" enctype="multipart/form-data" method="post" autocomplete="off">
                                {{ method_field('patch') }}
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="hidden" name="id" id="id">
                                    <label for="price">{{__('Dashboard/products.price')}}</label>
                                    <input placeholder="price" class="form-control" name="price" id="price" type="text">
                                    <br>
                                    <label for="price">{{__('Dashboard/products.start_time')}}</label>
                                    <input class="form-control fc-datepicker" name="start_time" placeholder="YYYY-MM-DD"
                                    type="date"  id="start_time">
                                    <br>
                                    <label for="price">{{__('Dashboard/products.end_time')}}</label>
                                    <input class="form-control fc-datepicker" name="end_time" placeholder="YYYY-MM-DD"
                                    type="date" id="end_time">
                                    <br>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">{{__('Dashboard/products.submit')}}</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Dashboard/products.Close')}}</button>
                                </div>
                            </form>
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
                        <form action="{{route('promotion.destroy')}}" method="post">
                            {{ method_field('delete') }}
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <p>{{__('Dashboard/products.aresuredeleting')}}</p><br>
                                <input type="hidden" name="id" id="id">
                                <input type="hidden" value="1" name="page_id">
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

    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var start_time = button.data('start_time')
            var end_time = button.data('end_time')
            var price = button.data('price')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #start_time').val(start_time);
            modal.find('.modal-body #end_time').val(end_time);
            modal.find('.modal-body #price').val(price);
        })
    </script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var title = button.data('title')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #title').val(title);
        })
    </script>
@endsection
