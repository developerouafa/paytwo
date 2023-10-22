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
                    @can('Show Product')
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table key-buttons text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{__('Dashboard/products.product')}}</th>
                                            <th>{{__('Dashboard/products.description')}}</th>
                                            <th>{{__('Dashboard/products.price')}}</th>
                                            <th>{{__('Dashboard/products.section')}}</th>
                                            <th>{{__('Dashboard/products.children')}}</th>
                                            <th>{{__('Dashboard/products.images')}}</th>
                                            @can('promotion Product')
                                                <th>{{__('Dashboard/products.promotion')}}</th>
                                            @endauth
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
                                                            <td> {{$x->name}} </td>
                                                            <td>{{ \Str::limit($x->description, 50) }}</td>
                                                            <td> {{$x->price}}</td>
                                                            <td> {{$x->section->name}} </td>
                                                            <td> {{$x->subsections->name}} </td>
                                                            <td><a href="{{ url('Products/images/images') }}/{{ $x->id }}">{{__('Dashboard/products.viewimages')}}</a></td>
                                                            <td>
                                                                @can('promotion Product')
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
                                                                @endcan
                                                            </td>
                                                            <td>
                                                                @can('stock Product')
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
                                                                @endcan
                                                            </td>
                                                            <td><a href="#">{{$x->user->name}}</a> </td>
                                                            <td> {{ $x->created_at->diffForHumans() }} </td>
                                                            <td> {{ $x->updated_at->diffForHumans() }} </td>
                                                            <td>
                                                                <a href="{{route('restorepr', $section->id)}}">{{__('Dashboard/messages.restore')}}</a>
                                                                <form action="{{route('forcedeletepr', $section->id)}}" method="get">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-danger">{{__('Dashboard/messages.deletee')}}</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endif
                                            @if (empty($x->parent_id) && !empty($x->section_id))
                                                @if ($x->section->status == 0)
                                                    <tr>
                                                        <td> {{$x->id}} </td>
                                                        <td> {{$x->name}} </td>
                                                        <td>{{ \Str::limit($x->description, 50) }}</td>
                                                        <td> {{$x->price}}</td>
                                                        <td> {{$x->section->name}} </td>
                                                        <td> {{__('Dashboard/sections_trans.nochildsection')}} </td>
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
                                                        <td><a href="#">{{$x->user->name}}</a> </td>
                                                        <td> {{ $x->created_at->diffForHumans() }} </td>
                                                        <td> {{ $x->updated_at->diffForHumans() }} </td>
                                                        <td>
                                                            <a href="{{route('restorepr', $section->id)}}">{{__('Dashboard/messages.restore')}}</a>
                                                            <form action="{{route('forcedeletepr', $section->id)}}" method="get">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger">{{__('Dashboard/messages.deletee')}}</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            @if (empty($x->section_id))
                                                <tr>
                                                    <td> {{$x->id}} </td>
                                                    <td> {{$x->name}} </td>
                                                    <td>{{ \Str::limit($x->description, 50) }}</td>
                                                    <td> {{$x->price}}</td>
                                                    <td> {{__('Dashboard/sections_trans.nosection')}} </td>
                                                    <td> {{__('Dashboard/sections_trans.nochildsection')}} </td>
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
                                                    <td><a href="#">{{$x->user->name}}</a> </td>
                                                    <td> {{ $x->created_at->diffForHumans() }} </td>
                                                    <td> {{ $x->updated_at->diffForHumans() }} </td>
                                                    <td>
                                                        <a href="{{route('restorepr', $x->id)}}">{{__('Dashboard/messages.restore')}}</a>
                                                        <form action="{{route('forcedeletepr', $x->id)}}" method="get">
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
