<!-- Upload Bukti -->
<div id="ModalRejectOrder" class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="form_reject_order">
        @csrf
        <div class="modal-body">
          <div class="text-center my-2" style="font-size: 2rem; padding:0 1rem">Enter The Reason For Rejection</div>
          <div class="form-group my-3">
            <input id="refusal_reason" name="refusal_reason" type="text" class="form-control mt-1">
            <div class="text-danger mt-3" id="message_reject_order" style="display: none"></div>
          </div>
        </div>
        <div class="d-flex justify-content-center align-items-center mb-3">
          <button class="btn btn-secondary me-2" data-bs-dismiss="modal" data-bs-toggle="modal" href="#OrderDetailModal"
            type="button">back</button>
          <button id="button_reject_order" class="btn btn btn-dark" type="submit">submit</button>
        </div>
      </form>
    </div>
  </div>
</div>