<!-- Common error display section -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<input type="number" name="user_id" value="{{ Auth::id() }}" hidden>

<div class="form-row">
    <div class="col-md-6 mb-3">
        <label for="category" class="form-label">Category</label>
        <select name="category" id="category" class="form-control select2 @error('category') is-invalid @enderror" required>
            <option disabled selected>Choose a Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="sub_category" class="form-label">Sub Category</label>
        <select name="sub_category" id="sub_category" class="form-control select2 @error('sub_category') is-invalid @enderror">
            <!-- Options will be loaded dynamically using JavaScript -->
        </select>
        @error('sub_category')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group">
    <label for="files">Upload Images</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input @error('files') is-invalid @enderror" id="files" name="files[]" multiple accept="image/*" required>
        <label class="custom-file-label" for="image">Choose file</label>
    </div>
    <div class="preview-container mt-3" id="previewContainer"></div>
    @error('files')
    <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
