@extends('layouts.app')

@section('content')
    <div class="container">
        @include('partials.form_heading', ['title' => 'Sub Category Detail'])

        <div class="row justify-content-center m-2">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Sub Category Detail') }}</div>
                    <div class="card-body">
                        @include('sub_categories.form', ['subCategory' => $subCategory, 'readOnly' => true])
                        @include('partials.image_display', ['image' => $subCategory])
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
