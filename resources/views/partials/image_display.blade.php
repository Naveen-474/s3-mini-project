@if(isset($image) && $image->image)
    <div class="form-group">
        <label for="old_image">Image</label>
        <div>
            <img src="{{ $image->image }}" alt="Sub Category Image" class="img-fluid" style="width: 300px; height: auto;">
        </div>
    </div>
@else
    <p>No image available</p>
@endif
