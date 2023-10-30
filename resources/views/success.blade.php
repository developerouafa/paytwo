@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Success') }}</div>

                    <div class="card-body">
                        Payment successful.
                    </div>

                    <button class="mt-4 btn btn-primary">Back to the Invoice</button>
                </div>
            </div>
        </div>
    </div>
@endsection

