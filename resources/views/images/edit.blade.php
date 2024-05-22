@extends('layouts.app')
@section('content')
    @include('images.css')
    @include('partials.form_heading', ['title' => 'Delete Images'])

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
                                    <img src="{{ $image->image }}" class="img-thumbnail" alt="Preview"
                                         data-image-id="{{ $image->id }}" onclick="displayFullSize('{{ $image->image }}')">
                                    <span class="delete-button" onclick="deleteImage('{{ $image->id }}')"
                                          data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"><i
                                            class="fas fa-times"></i></span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('jscontent')
<script>
    function deleteImage(imageId) {
        if (confirm("Are you sure you want to delete this image?")) {
            fetch(`{{ route('image.destroy', ['image' => '__imageId__']) }}`.replace('__imageId__', imageId), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
            })
                .then(response => {
                    if (response.ok) {
                        // Remove the image element from the preview
                        const previewContainer = document.getElementById('previewContainer');
                        const imageElement = previewContainer.querySelector(`img[data-image-id='${imageId}']`);
                        if (imageElement) {
                            imageElement.parentElement.remove();
                        }
                        // Optionally, you can display a success message or perform any other actions
                    } else {
                        // Handle error response
                    }
                })
                .catch(error => {
                    // Handle network errors
                });
        }
    }

</script>
@endsection
