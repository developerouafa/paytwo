@extends('Dashboard/layouts.master')
@section('title')
    {{__('Dashboard/products.addproducts')}}
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-children mb-0 my-auto">{{__('Dashboard/products.addproducts')}}</h4>
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
        <div class="card">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('Products.index') }}">{{__('Dashboard/messages.back')}}</a>
                    </div>
                </div>
                <!-- Basic modal -->
                    <div class="modal-body">
                        <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="inputName1" class="control-label">{{__('Dashboard/products.product_english')}}<span class="tx-danger">*</span></label>
                                        <input type="text" value="{{old('name_en')}}" class="form-control @error('name_en') is-invalid @enderror" id="name_en" name="name_en">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputName1" class="control-label">{{__('Dashboard/products.product_arabic')}}<span class="tx-danger">*</span></label>
                                        <input type="text" value="{{old('name_ar')}}" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" name="name_ar">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="inputName1" class="control-label">{{__('Dashboard/products.descriptionen')}}</label>
                                        <textarea type="text" value="{{old('description_en')}}" class="form-control @error('description_en') is-invalid @enderror" id="description_en" name="description_en" cols="5" rows="1"></textarea>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputName1" class="control-label">{{__('Dashboard/products.discriptionar')}}</label>
                                        <textarea type="text" value="{{old('description_ar')}}" class="form-control @error('description_ar') is-invalid @enderror" id="description_ar" name="description_ar" cols="5" rows="1"></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="inputName" class="control-label">{{__('Dashboard/products.section')}}<span class="tx-danger">*</span></label>
                                        <select name="section" class="form-control SlectBox @error('price') is-invalid @enderror" id="price" name="price" onclick="console.log($(this).val())"
                                            onchange="console.log('change is firing')">
                                            <option value="" selected disabled>{{__('Dashboard/products.selectsection')}}</option>
                                            @foreach ($sections as $section)
                                                @if ($section->status == 0)
                                                    <option value="{{ $section->id }}"> {{ $section->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="inputName1" class="control-label">{{__('Dashboard/products.children')}}<span class="tx-danger">*</span></label>
                                        <select id="children" name="children"  class="form-control @error('price') is-invalid @enderror">
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="inputName1" class="control-label">{{__('Dashboard/products.price')}}<span class="tx-danger">*</span></label>
                                        <input type="number" value="{{old('price')}}" class="form-control @error('price') is-invalid @enderror" id="price" name="price">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn ripple btn-primary" type="submit">{{__('Dashboard/products.submit')}}</button>
                            </div>
                        </form>
                    </div>
                <!-- End Basic modal -->
            </div>
        </div>
    <!-- row closed -->

@endsection
@section('js')
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

@endsection

