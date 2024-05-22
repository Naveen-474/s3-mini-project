@section('jscontent')
    <script>
        $(document).ready(function () {
            $('#category').on('change', function () {
                var categoryId = $(this).val();
                $.ajax({
                    url: '/get-subcategories/' + categoryId,
                    type: 'GET',
                    success: function (response) {
                        const subCategorySelect = document.getElementById('sub_category');
                        subCategorySelect.innerHTML = '<option value="" selected disabled>Choose Sub Category</option>';
                        response.forEach(subCategory => {
                            const option = document.createElement('option');
                            option.value = subCategory.id;
                            option.text = subCategory.name;
                            subCategorySelect.appendChild(option);
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });

        // Preview images
        document.getElementById('files').addEventListener('change', function () {
            const files = Array.from(this.files);
            const previewContainer = document.getElementById('previewContainer');
            previewContainer.innerHTML = '';

            files.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const previewItem = document.createElement('div');
                    previewItem.classList.add('preview-item');
                    previewItem.innerHTML = `
                    <img src="${e.target.result}" class="img-thumbnail" alt="Preview">
                    <span class="delete-button" onclick="deletePreview(${index})" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"><i class="fas fa-times"></i></span>
                `;
                    previewContainer.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            });
        });

        function deletePreview(index) {
            const filesInput = document.getElementById('files');
            const files = Array.from(filesInput.files);
            files.splice(index, 1);

            const newFileList = new DataTransfer();
            files.forEach(file => {
                newFileList.items.add(file);
            });

            filesInput.value = '';
            filesInput.files = newFileList.files;
            document.getElementById('files').dispatchEvent(new Event('change'));
        }

    </script>
@endsection
