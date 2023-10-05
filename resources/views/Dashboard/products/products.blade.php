@extends('Dashboard/layouts.master')
@section('title')
    {{__('Dashboard/products.products')}}
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-children mb-0 my-auto">{{__('Dashboard/products.products')}}</h4>
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
                            <a class="btn btn-outline-primary btn-block" href="{{route('product.createprod')}}">{{__('Dashboard/products.addproducts')}}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table key-buttons text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{__('Dashboard/products.product')}}</th>
                                        <th scope="col">{{__('Dashboard/products.description')}}</th>
                                        <th scope="col">{{__('Dashboard/products.price')}}</th>
                                        <th scope="col">{{__('Dashboard/products.section')}}</th>
                                        <th scope="col">{{__('Dashboard/products.children')}}</th>
                                        <th scope="col">{{__('Dashboard/products.status')}}</th>
                                        <th scope="col">{{__('Dashboard/products.userproduct')}}</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $x)
                                        @if ($x->section->status == 0)
                                            <tr>
                                                <td> {{$x->id}} </td>
                                                <td> {{$x->name}} </td>
                                                <td> {{$x->description}} </td>
                                                {{-- <td> {{__('message.$')}} {{$x->price}}</td>
                                                <td>{{$x->category->title}}</td>
                                                <td>{{$x->subcategories->title}}</td>
                                                <td><a href="{{ url('images/images') }}/{{ $x->id }}">{{__('Dashboard/products.viewimages')}}</a></td>
                                                <td><a href="{{ url('sizes/sizes') }}/{{ $x->id }}">{{__('Dashboard/products.viewsize')}}</a></td>
                                                <td>
                                                    @if ($x->status == 0)
                                                        <a href="{{route('products.editstatusdéactive', $x->id)}}">{{__('Dashboard/products.disabled')}}</a>
                                                    @endif
                                                    @if ($x->status == 1)
                                                        <a href="{{route('products.editstatusactive', $x->id)}}">{{__('Dashboard/products.active')}}</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @forelse ($x->promotion as $promo)
                                                        @if ($promo->expired == 0)
                                                            <a href="{{ url('promotions/promotions') }}/{{ $x->id }}">
                                                                {{__('Dashboard/products.thereisanpromotionfortheproduct')}}
                                                            </a>
                                                        @else
                                                            <a href="{{ url('promotions/promotions') }}/{{ $x->id }}">
                                                                {{__('Dashboard/products.promotioniscancel')}}
                                                            </a>
                                                        @endif
                                                    @empty
                                                        <a class="modal-effect btn btn-sm btn-secondary" data-effect="effect-scale"
                                                        data-id="{{ $x->id }}" data-price="{{ $x->price }}" data-toggle="modal"
                                                        href="#modaldemopromotion">{{__('Dashboard/products.addpromotion')}}</a>
                                                    @endforelse ()
                                                </td>
                                                <td>
                                                    @foreach ($stockproduct as $ss)
                                                        @if ($ss->product_id == $x->id)
                                                            @if ($ss->stock == "0")
                                                                <a href="{{route('stock.editstocknoexist', $ss->id)}}" style="color: green;">{{ __('Dashboard/products.existinstock') }}</a>
                                                            @endif
                                                            @if ($ss->stock == "1")
                                                                <a href="{{route('stock.editstockexist', $ss->id)}}" style="color: red;">{{ __('Dashboard/products.noexistinstock') }}</a>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                            data-id="{{ $x->id }}" data-title="{{ $x->title }}"
                                                            data-description="{{ $x->description }}" data-price="{{ $x->price }}" data-category_id="{{ $x->category->title }}" data-children_id="{{ $x->subcategories->title }}" data-toggle="modal"
                                                            href="#exampleModal2" title="Update">
                                                            <i class="las la-pen"></i>
                                                        </a>
                                                </td> --}}
                                                <td>
                                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                            data-id="{{ $x->id }}" data-title="{{ $x->title }}"
                                                            data-toggle="modal" href="#modaldemo9" title="Delete">
                                                            <i class="las la-trash"></i>
                                                        </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        <!-- edit -->
            {{-- <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{__('message.updatetitle')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('product.update')}}" enctype="multipart/form-data" method="post" autocomplete="off">
                                {{ method_field('patch') }}
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="hidden" name="id" id="id">
                                    <input placeholder="{{__('Dashboard/products.title')}}" class="form-control" name="title_{{app()->getLocale()}}" id="title" type="text">
                                    <br>
                                    <textarea placeholder="{{__('Dashboard/products.description')}}" type="text" value="{{old('description')}}" class="form-control @error('description') is-invalid @enderror" id="description" name="description_{{app()->getLocale()}}" cols="5" rows="1"></textarea>
                                    <br>
                                    <input placeholder="{{__('Dashboard/products.price')}}" class="form-control" name="price" id="price" type="text">
                                    <br>
                                    <div class="col">
                                        <label for="inputName" class="control-label">{{__('Dashboard/products.Categories')}}</label>
                                        <select name="Category" class="form-control SlectBox" onclick="console.log($(this).val())" onchange="console.log('change is firing')">
                                            <option value="" selected disabled>{{__('Dashboard/products.selectcategory')}}</option>
                                            @foreach ($categories as $category)
                                                @if ($category->status == 0)
                                                    <option value="{{ $category->id }}"> {{ $category->title }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="inputName1" class="control-label">{{__('Dashboard/products.children')}}</label>
                                        <select id="children" name="children" class="form-control">
                                        </select>
                                    </div>
                                    <br>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">{{__('message.save')}}</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('message.close')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> --}}

        <!-- delete -->
            {{-- <div class="modal" id="modaldemo9">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title">{{__('message.deletee')}}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form action="{{route('product.delete')}}" method="post">
                            {{ method_field('delete') }}
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <p>{{__('message.aresuredeleting')}}</p><br>
                                <input type="hidden" name="id" id="id">
                                <input class="form-control" name="title" id="title" type="text" readonly>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('message.close')}}</button>
                                <button type="submit" class="btn btn-danger">{{__('message.deletee')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}

    </div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('select[name="Category"]').on('change', function() {
                var CategoryId = $(this).val();
                if (CategoryId) {
                    $.ajax({
                        url: "{{ URL::to('category') }}/" + CategoryId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="children"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="children"]').append('<option value="' +
                                value + '">' + key + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
    </script>

    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var title = button.data('title')
            var description = button.data('description')
            var category_id = button.data('category_id')
            var children_id = button.data('children_id')
            var price = button.data('price')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #title').val(title);
            modal.find('.modal-body #description').val(description);
            modal.find('.modal-body #category_id').val(category_id);
            modal.find('.modal-body #children_id').val(children_id);
            modal.find('.modal-body #price').val(price);
        })
    </script>

    <script>
        $('#modaldemopromotion').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var price = button.data('price')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
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
