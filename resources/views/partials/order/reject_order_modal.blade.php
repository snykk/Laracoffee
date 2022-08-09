<!-- Upload Bukti -->
<div id="ModalRejectOrder" class="modal fade" style="text-transform: capitalize;" data-bs-keyboard="false"
  data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">reason of order refuse</h4>
        <button type="button" class="btn m-0 p-0 d-flex justify-content-center align-items-center"
          data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-fw fa-solid fa-xmark"
            style="color: white;font-size:1.5rem; padding:0"></i></button>
      </div>
      <form method="post" id="form_reject_order">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="refusal_reason">refusal reason</label>
            <input id="refusal_reason" name="refusal_reason" type="text" class="form-control mt-1">
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-outline-secondary" data-bs-dismiss="modal" data-bs-toggle="modal"
            href="#OrderDetailModal" type="button">back</button>
          <button id="submit_refusal" class="btn btn btn-outline-dark" data-bs-dismiss="modal"
            type="submit">submit</button>
        </div>
      </form>
    </div>
  </div>
</div>