@extends('layouts.app')

@section('content')
    <div class="container">
        @include('partials.form_heading', ['title' => 'Create Sub Category'])
        <div class="row justify-content-center m-2">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Sub Category') }}</div>
                    <div class="card-body">
                        <form action="{{ url('sub-categories') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('sub_categories.form')
                            <div style="margin-top: 20px;">
                                <a href="{{ route('sub-categories.index') }}" class="btn btn-danger">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
