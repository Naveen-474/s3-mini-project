@extends('layouts.app')
@section('content')
    @include('images.css')
    <div class="container">
        @include('partials.form_heading', ['title' => 'Upload Image'])
        <div class="row justify-content-center">
            <div class="col-xl-11 col-lg-10 mt-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-0 font-weight-bold text-primary">Upload Image</h5>
                    </div>
                    <div class="card-body">
                        <div class="form px-3">
                            <form action="{{ route('image.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @include('images.form')
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary mr-3">Submit</button>
                                    <a href="{{ route('image.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('images.script');
