@extends('layouts.app')

@section('content')
    <div class="container">
        @include('partials.form_heading', ['title' => 'Category Detail'])

        <div class="row justify-content-center m-2">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Category Detail') }}</div>
                    <div class="card-body">
                        @include('categories.form', ['category' => $category, 'readOnly' => true])
                        @include('partials.image_display', ['image' => $category])
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
