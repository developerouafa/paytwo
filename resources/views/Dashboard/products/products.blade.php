@extends('Dashboard/layouts.master')
@section('title')
    {{__('Dashboard/products.products')}}
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
                            <a class="btn btn-outline-primary btn-block" href="{{route('product.createprod')}}">{{__('Dashboard/products.addproduct')}}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap" id="example2">
                                <thead>
                                    <tr>
                                        <th scope="wd-15p border-bottom-0">#</th>
                                        <th scope="wd-15p border-bottom-0">{{__('Dashboard/products.product')}}</th>
                                        <th scope="wd-15p border-bottom-0">{{__('Dashboard/products.description')}}</th>
                                        <th scope="wd-15p border-bottom-0">{{__('Dashboard/products.price')}}</th>
                                        <th scope="wd-15p border-bottom-0">{{__('Dashboard/products.section')}}</th>
                                        <th scope="wd-15p border-bottom-0">{{__('Dashboard/products.children')}}</th>
                                        <th scope="wd-15p border-bottom-0">{{__('Dashboard/products.status')}}</th>
                                        <th scope="wd-15p border-bottom-0">{{__('Dashboard/products.userproduct')}}</th>
                                        <th scope="wd-15p border-bottom-0">{{__('Dashboard/products.images')}}</th>
                                        <th scope="wd-15p border-bottom-0">{{__('Dashboard/products.promotion')}}</th>
                                        <th scope="wd-15p border-bottom-0">{{__('Dashboard/products.stock')}}</th>
                                        <th scope="wd-15p border-bottom-0"></th>
                                        <th scope="wd-15p border-bottom-0"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $x)
                                        @if ($x->section->status == 0)
                                            <tr>
                                                <td> {{$x->id}} </td>
                                                <td> {{$x->name}} </td>
                                                <td> {{$x->description}} </td>
                                                <td> {{$x->price}}</td>
                                                <td> {{$x->section->name}} </td>
                                                <td> {{$x->subsections->name}} </td>
                                                <td>
                                                    @if ($x->status == 0)
                                                        <a href="{{route('editstatusdéactive', $x->id)}}">{{__('Dashboard/products.disabled')}}</a>
                                                    @endif
                                                    @if ($x->status == 1)
                                                        <a href="{{route('editstatusactive', $x->id)}}">{{__('Dashboard/products.active')}}</a>
                                                    @endif
                                                </td>
                                                <td> {{$x->user->name}} </td>
                                                <td><a href="{{ url('Products/images/images') }}/{{ $x->id }}">{{__('Dashboard/products.viewimages')}}</a></td>
                                                <td>
                                                    @forelse ($x->promotion as $promo)
                                                        @if ($promo->expired == 0)
                                                            <a href="{{ url('Products/promotions/promotions') }}/{{ $x->id }}">
                                                                {{__('Dashboard/products.thereisanpromotionfortheproduct')}}
                                                            </a>
                                                        @else
                                                            <a href="{{ url('Products/promotions/promotions') }}/{{ $x->id }}">
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
                                                            data-id="{{ $x->id }}" data-name="{{ $x->name }}"
                                                            data-description="{{ $x->description }}" data-price="{{ $x->price }}" data-section_id="{{ $x->section->name }}" data-children_id="{{ $x->subsections->name }}" data-toggle="modal"
                                                            href="#exampleModal2" title="Update">
                                                            <i class="las la-pen"></i>
                                                        </a>
                                                </td>
                                                <td>
                                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                            data-id="{{ $x->id }}" data-name="{{ $x->name }}"
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


        <!-- Add Promotion -->
            <div class="modal" id="modaldemopromotion">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title">{{__('Dashboard/products.addpromotion')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                            <div class="modal-body">
                                <form action="{{route('promotions.create')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                        <div class="form-group">
                                            <input type="hidden" name="id" id="id">
                                            <label for="price">{{__('Dashboard/products.updatepricepromotion')}}</label>
                                            <input placeholder="{{__('Dashboard/products.updatepricepromotion')}}" class="form-control" name="price" id="price" type="text">
                                            <br>
                                            <label for="price">{{__('Dashboard/products.start_time')}}</label>
                                            <input class="form-control fc-datepicker" name="start_time" placeholder="{{__('Dashboard/products.start_time')}}"
                                            type="date" value="{{ date('Y-m-d') }}" id="start_time">
                                            <br>
                                            <label for="price">{{__('Dashboard/products.end_time')}}</label>
                                            <input class="form-control fc-datepicker" name="end_time" placeholder="{{__('Dashboard/products.end_time')}}"
                                            type="date" id="end_time">
                                            <br>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn ripple btn-primary" type="submit">{{__('Dashboard/products.submit')}}</button>
                                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{__('Dashboard/products.Close')}}</button>
                                        </div>
                                </form>
                            </div>
                    </div>
                </div>
            </div>

        <!-- edit -->
            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{__('Dashboard/products.updateproduct')}}</h5>
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
                                    <input placeholder="{{__('Dashboard/products.product')}}" class="form-control @error('description') is-invalid @enderror" name="name_{{app()->getLocale()}}" id="name" type="text">
                                    <br>
                                    <textarea placeholder="{{__('Dashboard/products.description')}}" type="text" value="{{old('description')}}" class="form-control @error('description') is-invalid @enderror" id="description" name="description_{{app()->getLocale()}}" cols="5" rows="1"></textarea>
                                    <br>
                                    <input placeholder="{{__('Dashboard/products.price')}}" class="form-control" name="price" id="price" type="text">
                                    <br>
                                    <div class="col">
                                        <label for="inputName" class="control-label">{{__('Dashboard/products.section')}}</label>
                                        <select name="section" class="form-control SlectBox" onclick="console.log($(this).val())" onchange="console.log('change is firing')">
                                            <option value="" selected disabled>{{__('Dashboard/products.selectsection')}}</option>
                                            @foreach ($sections as $section)
                                                @if ($section->status == 0)
                                                    <option value="{{ $section->id }}"> {{ $section->name }}</option>
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
                        <form action="{{route('product.destroy')}}" method="post">
                            {{ method_field('delete') }}
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <p>{{__('Dashboard/products.aresuredeleting')}}</p><br>
                                <input type="hidden" name="id" id="id">
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
        $(document).ready(function() {
            $('select[name="section"]').on('change', function() {
                var sectionId = $(this).val();
                if (sectionId) {
                    $.ajax({
                        url: "{{ URL::to('section') }}/" + sectionId,
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
            var name = button.data('name')
            var description = button.data('description')
            var section_id = button.data('section_id')
            var children_id = button.data('children_id')
            var price = button.data('price')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #description').val(description);
            modal.find('.modal-body #section_id').val(section_id);
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
            var name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
        })
    </script>
@endsection
