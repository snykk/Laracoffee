import { previewImage } from "/js/image_preview.js";

$("#image").on("change", function () {
    previewImage({
        image: "image",
        image_preview: "image-preview",
        image_preview_alt: "Profile Image",
    });
});
