<div class="form-group">
    <label for="name">Sub Category Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $subCategory->name ?? '') }}" {{ isset($readOnly) && $readOnly ? 'readonly' : '' }} required>
    @error('name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    @if(isset($readOnly) && $readOnly)
        <label for="category-id" class="form-label">Category</label>
        <p class="form-control-plaintext">{{ $subCategory->category->name ?? 'N/A' }}</p>
    @else
        <label for="category-id" class="form-label">Category</label>
        <select name="category_id" class="form-control select2 @error('category_id') is-invalid @enderror">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ (old('category_id', $subCategory->category_id ?? '') == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    @endif
</div>

<div class="form-group">
    @if(!(isset($readOnly) && $readOnly))
        <label for="image">Sub Category Image</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" {{ isset($subCategory) && !$subCategory->id ? 'required' : '' }}>
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
