@extends('layouts.app')

@section('content')
    <div class="container">
        @include('partials.form_heading', ['title' => 'Update Category'])

        <div class="row justify-content-center m-2">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Update Category') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <form id="updateCategoryForm" action="{{ url('/category/' . $category->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    @include('categories.form', ['category' => $category])
                                    <div style="margin-top: 20px;">
                                        <a href="{{ route('category.index') }}" class="btn btn-danger">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                @include('partials.image_display', ['image' => $category])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
