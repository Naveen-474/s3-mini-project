<div class="form-group">
    <label for="name">Category Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $category->name ?? '') }}" {{ isset($readOnly) && $readOnly ? 'readonly' : '' }} required>
    @error('name')
    <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<div class="form-group">
    @if(!(isset($readOnly) && $readOnly))
        <label for="image">Category Image</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" {{ isset($category) && !$category->id ? 'required' : '' }}>
            <label class="custom-file-label" for="image">Choose file</label>
            @error('image')
            <span class="invalid-feedback d-block" role="alert">
                 <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="preview-container mt-2" id="previewContainer">
            <!-- Preview container will be displayed here -->
        </div>
    @endif
</div>
