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
    <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">{{__('Dashboard/products.images')}}</h4>
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
        @can('Show main&multip images products')
            <div class="col-xl-12">
                <div class="card mg-b-20">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <a class="modal-effect btn btn-primary" data-effect="effect-scale" data-toggle="modal"
                            href="#modaldemo8" title="Update">
                            {{__('Dashboard/products.addimagesgallary')}}</a>
                            <a class="btn btn-danger" href="{{route('image.deleteall')}}">{{__('Dashboard/messages.Deleteall')}}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table key-buttons text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('Dashboard/products.products')}}</th>
                                        <th>{{__('Dashboard/products.mainimage')}}</th>
                                        {{-- <th>{{__('Dashboard/users.createdbyuser')}}</th>
                                        <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                                        <th>{{__('Dashboard/sections_trans.updated_at')}}</th> --}}
                                        <th>{{__('Dashboard/products.galleryimages')}}</th>
                                        {{-- <th>{{__('Dashboard/users.createdbyuser')}}</th>
                                        <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                                        <th>{{__('Dashboard/sections_trans.updated_at')}}</th> --}}
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

                                                    @can('Edit main image Product')
                                                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                        data-id="{{ $x->id }}" data-toggle="modal"
                                                        href="#exampleModal3" title="Update">
                                                        <i class="las la-pen"></i></a>
                                                    @endcan

                                                    @can('Delete main image Product')
                                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                        data-id="{{ $x->id }}" data-toggle="modal"
                                                        href="#exampleModal5" title="Delete">
                                                        <i class="las la-trash"></i></a>
                                                    @endcan

                                                </td>
                                                {{-- <td><a href="#">{{$mainimage->user->name}}</a> </td>
                                                <td> {{ $mainimage->created_at->diffForHumans() }} </td>
                                                <td> {{ $mainimage->updated_at->diffForHumans() }} </td> --}}
                                            @empty
                                                <b>
                                                    <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal"
                                                    href="#modaldemo9" title="Update">
                                                    {{__('Dashboard/products.addimagesmain')}}</a>
                                                </b>
                                            @endforelse ()
                                            @foreach ($multimg as $x)
                                                <td>
                                                    <img src="{{asset('storage/'.$x->multipimage)}}" alt="" style="width: 80px; height:80px;">
                                                    <br>

                                                    @can('Edit multip image Product')
                                                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                        data-id="{{ $x->id }}" data-toggle="modal"
                                                        href="#exampleModal2" title="Update">
                                                        <i class="las la-pen"></i></a>
                                                    @endcan

                                                    @can('Delete multip image Product')
                                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                        data-id="{{ $x->id }}" data-toggle="modal"
                                                        href="#exampleModal4" title="Delete">
                                                        <i class="las la-trash"></i></a>
                                                    @endcan
                                                </td>
                                                {{-- <td><a href="#">{{$multimg->user->name}}</a> </td>
                                                <td> {{ $multimg->created_at->diffForHumans() }} </td>
                                                <td> {{ $multimg->updated_at->diffForHumans() }} </td> --}}
                                            @endforeach
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        <!-- Add Main Images -->
            <div class="modal" id="modaldemo9">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title">{{__('Dashboard/products.addimagesmain')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                            <div class="modal-body">
                                <form action="{{route('imagemain.create')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                        <div class="form-group">
                                            <input placeholder="product_id" type="hidden" id="product_id" name="product_id" value="{{$Product->id}}">
                                            <div class="from-group">
                                                <label for="files" class="form-label mt-4">{{__('Dashboard/products.uploadmoreimage')}}</label>
                                                <input id="image" type="file" name="image" data-height="200" accept=".jpg, .png, image/jpeg, image/png" class="dropify @error('image') is-invalid @enderror">
                                            </div>
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
        <!-- End Basic modal -->

        <!-- Add Multip Images -->
            <div class="modal" id="modaldemo8">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title">{{__('Dashboard/products.addimagesgallary')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                            <div class="modal-body">
                                <form action="{{route('image.create')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                        <div class="form-group">
                                            <input placeholder="product_id" type="hidden" id="product_id" name="product_id" value="{{$Product->id}}">
                                            <div class="from-group">
                                                <label for="files" class="form-label mt-4">{{__('Dashboard/products.uploadmoreimages')}}</label>
                                                <input id="image" type="file" name="image" data-height="200" accept=".jpg, .png, image/jpeg, image/png" class="dropify @error('image') is-invalid @enderror">
                                            </div>
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
        <!-- End Basic modal -->

        <!-- edit Main Images -->
            <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('imagemain.edit')}}" enctype="multipart/form-data" method="post" autocomplete="off">
                                {{ method_field('patch') }}
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="hidden" name="id" id="id">
                                </div>
                                <div class="form-group">
                                    <input type="file" class="dropify @error('image') is-invalid @enderror" data-height="200" name="image" accept=".jpg, .png, image/jpeg, image/png"/>
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
        <!-- End Basic modal -->

        <!-- edit Multip Images -->
            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('image.edit')}}" enctype="multipart/form-data" method="post" autocomplete="off">
                                {{ method_field('patch') }}
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="hidden" name="id" id="id">
                                </div>
                                <div class="form-group">
                                    <input type="file" class="dropify @error('image') is-invalid @enderror" data-height="200" name="image" accept=".jpg, .png, image/jpeg, image/png"/>
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
        <!-- End Basic modal -->

        <!-- delete Multip Images -->
            <div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('image.destroy')}}" method="post" >
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="hidden" name="id" id="id">
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
        <!-- End Basic modal -->

        <!-- delete Main Images -->
            <div class="modal fade" id="exampleModal5" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('imagemain.destroy')}}" method="post" >
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="hidden" name="id" id="id">
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
        <!-- End Basic modal -->
    </div>
    <!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')

    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script>

    <script>
        $('#exampleModal3').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script>

    <script>
        $('#exampleModal4').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script>

    <script>
        $('#exampleModal5').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>
@endsection
