<div id="ProofUploadModal" class="modal fade" style="text-transform: capitalize;" data-bs-keyboard="false"
  data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">upload bukti transfer</h4>
        <button type="button" class="btn m-0 p-0 d-flex justify-content-center align-items-center"
          data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-fw fa-solid fa-xmark"
            style="color: white;font-size:1.5rem; padding:0"></i></button>
      </div>
      <form id="form_upload_proof" method="post" enctype="multipart/form-data"> {{-- define action in js --}}
        @csrf
        <input type="hidden" name="old_image_proof" id="old_image_proof">
        <div class="modal-body">
          <div class="d-flex flex-column align-items-center text-center">
            <img id="image_review_upload" width="150">
            <div class="small font-italic text-muted">Must be an image no more than 2 MB</div>
            <div class="mt-2">
              <p class="mb-1" id="message_upload_proof"></p>
              <div class="custom-file">
                <input type="file" class="form-control" id="image_upload_proof" name="image_upload_proof">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-outline-secondary" data-bs-dismiss="modal" type="button"> back</button>
          <button class="btn btn btn-outline-dark" type="submit" id="submit_upload_proof">upload</button>
        </div>
      </form>
    </div>
  </div>
</div>