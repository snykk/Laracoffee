import { previewImage } from "./image_preview.js";

$("#image_proof_edit").on("change", function () {
    previewImage({
        image: "image_proof_edit",
        image_preview: "image_preview_proof_edit",
        image_preview_alt: "image proof preview",
    });
});
