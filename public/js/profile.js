$("#image").on("change", function previewImage() {
    console.log("mulai");
    const img = document.getElementById("image");
    const imgPreview = document.getElementById("image-preview");

    const oFReader = new FileReader();
    console.log("berjalan");
    oFReader.readAsDataURL(img.files[0]);

    oFReader.onload = function (oFREvent) {
        console.log(oFREvent.target.result);
        imgPreview.src = oFREvent.target.result;
        console.log("done");
    };
});
