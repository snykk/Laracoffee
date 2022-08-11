export function previewImage({
    image = "image",
    image_preview = "image-preview",
    image_preview_alt = "image preview",
}) {
    const img = document.getElementById(image);
    const imgPreview = document.getElementById(image_preview);

    const oFReader = new FileReader();
    oFReader.readAsDataURL(img.files[0]);

    oFReader.onload = function (oFREvent) {
        imgPreview.src = oFREvent.target.result;
        imgPreview.alt = image_preview_alt;
    };
}
