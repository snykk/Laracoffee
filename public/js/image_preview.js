$("#image").on("change", function previewImage() {
    const img = document.getElementById("image");
    const imgPreview = document.getElementById("image-preview");

    const oFReader = new FileReader();
    oFReader.readAsDataURL(img.files[0]);

    oFReader.onload = function (oFREvent) {
        imgPreview.src = oFREvent.target.result;
        imgPreview.alt = "New Product Image";
    };
});
