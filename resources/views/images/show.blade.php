@extends('layouts.app')
@section('content')
    @include('images.css')
    @include('partials.form_heading', ['title' => 'Show Images'])

    <div class="row justify-content-center">
        <div class="col-xl-11 col-lg-10 mt-5 ">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">Images On : {{ $subCategory->category->name ?? null }} / {{ $subCategory->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="form px-3">
                        <div class="preview-container" id="previewContainer">
                            @foreach($subCategory->images as $image)
                                <div class="preview-item">
                                    <img src="{{ $image->image }}" class="img-thumbnail" alt="Preview">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
