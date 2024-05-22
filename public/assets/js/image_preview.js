function previewImage() {
    var fileInput = document.getElementById('image');
    var imagePreview = document.getElementById('previewContainer');

    while (imagePreview.firstChild) {
        imagePreview.removeChild(imagePreview.firstChild);
    }

    if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-fluid mt-2';
            img.style.width = '300px';
            img.style.height = 'auto';
            imagePreview.appendChild(img);
        }
        reader.readAsDataURL(fileInput.files[0]);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var fileInput = document.getElementById('image');
    if (fileInput) {
        fileInput.addEventListener('change', previewImage);
    }

});
