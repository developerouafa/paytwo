{{--

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-Dashboard-app-layout> --}}
@extends('Dashboard/layouts.master')
@section('title')
{{__('Dashboard/profile.Edit-Profile')}}
@endsection
@section('css')
    <!-- Internal Select2 css -->

        <!--- Internal Select2 css-->
        <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
        <!---Internal Fileupload css-->
        <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
        <!---Internal Fancy uploader css-->
        <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
        <!--Internal Sumoselect css-->
        <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">


@endsection
@section('page-header')
    <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">{{__('Dashboard/profile.Pages')}} </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/profile.Edit-Profile')}}</span>
                </div>
            </div>
        </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <!-- Col -->
        <div class="col-lg-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <div class="main-profile-overview">
                                <div class="main-img-user profile-user">
                                    @foreach ($imageuser as $img)
                                            @if (empty($img->image->image))
                                                <img src="{{URL::asset('assets/img/faces/6.jpg')}}">
                                                <a class="fas fa-camera profile-edit" href=""></a>
                                            @else
                                                    <img src="{{URL::asset('storage/'.$img->image->image)}}">
                                                    <a class="fas fa-camera profile-edit" href="JavaScript:void(0);"></a>
                                                    <br>
                                                    <a class="fas fa-solid fa-trash" href="{{ route('imageuser.delete') }}" style="color: red"></a>
                                            <br>
                                        @endif
                                    @endforeach
                                </div>

                                @foreach ($imageuser as $img)
                                    @if (empty($img->image->image))
                                        <form action="{{ route('imageuser.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                                            {{ csrf_field() }}

                                            <input type="hidden" value="{{Auth::user()->id}}" name="id">

                                            <p class="text-danger">* {{__('Dashboard/profile.Attachmentformat')}}  pdf, jpeg ,.jpg , png </p>
                                            <h5 class="card-title"> {{__('Dashboard/profile.imageuser')}} </h5>

                                            <div class="col-sm-12 col-md-12">
                                                <input type="file" name="imageuser" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                    data-height="70" />
                                            </div><br>

                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-primary"> {{__('Dashboard/profile.saveimageuser')}} </button>
                                            </div>
                                        </form>
                                        @else
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <form action="{{ route('imageuser.update') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                                            {{ method_field('patch') }}
                                            {{ csrf_field() }}

                                            <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                            <h5 class="card-title"> {{__('Dashboard/profile.imageuserupdate')}} </h5>

                                            <div class="col-sm-12 col-md-12">
                                                <input type="file" name="imageuser" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                    data-height="70" />
                                            </div><br>

                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-primary"> {{__('Dashboard/profile.saveimageuser')}} </button>
                                            </div>
                                        </form>
                                    @endif
                                @endforeach

                            <div class="d-flex justify-content-between mg-b-20">
                                <div>
                                    <h5 class="main-profile-name">{{Auth::user()->name}}</h5>
                                </div>
                            </div>
                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
            {{-- <div class="card mg-b-20">
                <div class="card-body">
                    <div class="main-content-label tx-13 mg-b-25">
                        {{__('Dashboard/profile.contactinfo')}}
                    </div>
                    <div class="main-profile-contact-list">
                        <div class="media">
                            <div class="media-icon bg-primary-transparent text-primary">
                                <i class="icon ion-md-phone-portrait"></i>
                            </div>
                            <div class="media-body">
                                <span>{{__('Dashboard/profile.phone')}}</span>
                                <div>
                                    {{Auth::user()->phone}}
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-icon bg-info-transparent text-info">
                                <i class="icon ion-md-locate"></i>
                            </div>
                            <div class="media-body">
                                <span>{{__('Dashboard/users.adderss')}}</span>
                                <div>
                                    {{Auth::user()->profileuser->adderss}}
                                </div>
                            </div>
                        </div>
                    </div><!-- main-profile-contact-list -->
                </div>
            </div> --}}
        </div>

        <!-- Col -->
        {{-- <div class="col-lg-8">
            <div class="py-12">
                <div class="col-lg-12">
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl"> --}}
                            {{-- @include('profile.partials.update-profile-information-form') --}}
                        {{-- </div>
                    </div>

                </div>
            </div>
        </div> --}}
        <!-- /Col -->
    </div>
    <!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')

    <!--Internal  Chart.bundle js -->
    <script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <!-- Internal Select2.min js -->
    {{-- <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script> --}}
    {{-- <script src="{{URL::asset('assets/js/select2.js')}}"></script> --}}


        <!-- Internal Select2 js-->
        <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
        <!--Internal Fileuploads js-->
        <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
        <!--Internal Fancy uploader js-->
        <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
        <!--Internal  Form-elements js-->
        <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
        <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
        <!--Internal Sumoselect js-->
        <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
        <!--Internal  Datepicker js -->
        <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
        <!--Internal  jquery.maskedinput js -->
        <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
        <!--Internal  spectrum-colorpicker js -->
        <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
        <!-- Internal form-elements js -->
        <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
@endsection
