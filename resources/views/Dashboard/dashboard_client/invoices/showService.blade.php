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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table key-buttons text-md-nowrap" data-page-length="50" style="text-align: center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('Dashboard/products.product')}}</th>
                                        <th>{{__('Dashboard/products.description')}}</th>
                                        <th>{{__('Dashboard/products.price')}}</th>
                                        <th>{{__('Dashboard/products.section')}}</th>
                                        <th>{{__('Dashboard/products.children')}}</th>
                                        <th>{{__('Dashboard/products.images')}}</th>
                                        <th>{{__('Dashboard/products.promotion')}}</th>
                                        <th>{{__('Dashboard/products.stock')}}</th>
                                        <th>{{__('Dashboard/users.createdbyuser')}}</th>
                                        <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                                        <th>{{__('Dashboard/sections_trans.updated_at')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @if (!empty($product->section_id && $product->parent_id))
                                            @if ($product->section->status == 0)
                                                @if ($product->subsections->status == 0)
                                                    <tr>
                                                        <td> {{$product->id}} </td>
                                                        <td> {{$product->name}} </td>
                                                        <td>{{ \Str::limit($product->description, 50) }}</td>
                                                        <td> {{$product->price}}</td>
                                                        <td> {{$product->section->name}} </td>
                                                        <td> {{$product->subsections->name}} </td>
                                                        <td>
                                                            <a href="{{route('image.image', $product->id)}}">{{__('Dashboard/products.viewimages')}}</a>
                                                        <td>
                                                                @forelse ($product->promotion as $promo)
                                                                    @if ($promo->expired == 0)
                                                                        <a href="{{route('promotion.promotion', $product->id)}}">
                                                                            {{__('Dashboard/products.thereisanpromotionfortheproduct')}}
                                                                        </a>
                                                                    @else
                                                                        <a href="{{route('promotion.promotion', $product->id)}}">
                                                                            {{__('Dashboard/products.promotioniscancel')}}
                                                                        </a>
                                                                    @endif
                                                                @empty
                                                                    <b style="color: brown"> {{__('Dashboard/products.nopromotion')}} </b>
                                                                @endforelse ()
                                                        </td>
                                                        <td>
                                                                @foreach ($stockproduct as $ss)
                                                                    @if ($ss->product_id == $product->id)
                                                                        @if ($ss->stock == "0")
                                                                            <b style="color: green;">{{ __('Dashboard/products.existinstock') }}</b>
                                                                        @endif
                                                                        @if ($ss->stock == "1")
                                                                            <b style="color: red;">{{ __('Dashboard/products.noexistinstock') }}</b>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                        </td>
                                                        <td><a href="#">{{$product->user->name}}</a> </td>
                                                        <td> {{ $product->created_at->diffForHumans() }} </td>
                                                        <td> {{ $product->updated_at->diffForHumans() }} </td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endif
                                        @if (empty($product->parent_id) && !empty($product->section_id))
                                            @if ($product->section->status == 0)
                                                <tr>
                                                    <td> {{$product->id}} </td>
                                                    <td> {{$product->name}} </td>
                                                    <td>{{ \Str::limit($product->description, 50) }}</td>
                                                    <td> {{$product->price}}</td>
                                                    <td> {{$product->section->name}} </td>
                                                    <td> {{__('Dashboard/sections_trans.nochildsection')}} </td>
                                                    <td><a href="{{route('image.image', $product->id)}}">{{__('Dashboard/products.viewimages')}}</a></td>
                                                    <td>
                                                        @forelse ($product->promotion as $promo)
                                                            @if ($promo->expired == 0)
                                                                <a href="{{route('promotion.promotion', $product->id)}}">
                                                                    {{__('Dashboard/products.thereisanpromotionfortheproduct')}}
                                                                </a>
                                                            @else
                                                                <a href="{{route('promotion.promotion', $product->id)}}">
                                                                    {{__('Dashboard/products.promotioniscancel')}}
                                                                </a>
                                                            @endif
                                                        @empty
                                                            <b style="color: brown"> {{__('Dashboard/products.nopromotion')}} </b>
                                                        @endforelse ()
                                                    </td>
                                                    <td>
                                                        @foreach ($stockproduct as $ss)
                                                            @if ($ss->product_id == $product->id)
                                                                @if ($ss->stock == "0")
                                                                    <b style="color: green;">{{ __('Dashboard/products.existinstock') }}</b>
                                                                @endif
                                                                @if ($ss->stock == "1")
                                                                    <b style="color: red;">{{ __('Dashboard/products.noexistinstock') }}</b>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td><a href="#">{{$product->user->name}}</a> </td>
                                                    <td> {{ $product->created_at->diffForHumans() }} </td>
                                                    <td> {{ $product->updated_at->diffForHumans() }} </td>
                                                </tr>
                                            @endif
                                        @endif
                                        @if (empty($product->section_id))
                                            <tr>
                                                <td> {{$product->id}} </td>
                                                <td> {{$product->name}} </td>
                                                <td>{{ \Str::limit($product->description, 50) }}</td>
                                                <td> {{$product->price}}</td>
                                                <td> {{__('Dashboard/sections_trans.nosection')}} </td>
                                                <td> {{__('Dashboard/sections_trans.nochildsection')}} </td>
                                                <td><a href="{{route('image.image', $product->id)}}">{{__('Dashboard/products.viewimages')}}</a></td>
                                                <td>
                                                    @forelse ($product->promotion as $promo)
                                                        @if ($promo->expired == 0)
                                                            <a href="{{route('promotion.promotion', $product->id)}}">
                                                                {{__('Dashboard/products.thereisanpromotionfortheproduct')}}
                                                            </a>
                                                        @else
                                                            <a href="{{route('promotion.promotion', $product->id)}}">
                                                                {{__('Dashboard/products.promotioniscancel')}}
                                                            </a>
                                                        @endif
                                                    @empty
                                                        <b style="color: brown"> {{__('Dashboard/products.nopromotion')}} </b>
                                                    @endforelse ()
                                                </td>
                                                <td>
                                                    @foreach ($stockproduct as $ss)
                                                        @if ($ss->product_id == $product->id)
                                                            @if ($ss->stock == "0")
                                                                <b style="color: green;">{{ __('Dashboard/products.existinstock') }}</b>
                                                            @endif
                                                            @if ($ss->stock == "1")
                                                                <b style="color: red;">{{ __('Dashboard/products.noexistinstock') }}</b>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td><a href="#">{{$product->user->name}}</a> </td>
                                                <td> {{ $product->created_at->diffForHumans() }} </td>
                                                <td> {{ $product->updated_at->diffForHumans() }} </td>
                                            </tr>
                                        @endif
                                </tbody>
                            </table>
                        </div>
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
