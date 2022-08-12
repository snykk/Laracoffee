<div class="modal fade" id="EditReviewModal" tabindex="-1" aria-labelledby="EditReviewModalLabel" aria-hidden="true"
  data-bs-keyboard="false" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditReviewModalLabel">Edit Review</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="post" id="form_edit_review"> {{-- define action in js --}}
        @csrf
        <div class="modal-body">
          <p style="margin-bottom: 0 !important;">Pilih rating</p>

          <!-- star rating -->
          <div class="rating-wrapperr">

            <!-- star 5 -->
            <input type="radio" id="5-star-rating" name="rating" value="5">
            <label for="5-star-rating" class="star-rating" onclick="isClickStar(5)">
              <i class="fas fa-star d-inline-block"></i>
            </label>

            <!-- star 4 -->
            <input type="radio" id="4-star-rating" name="rating" value="4">
            <label for="4-star-rating" class="star-rating star" onclick="isClickStar(4)">
              <i class="fas fa-star d-inline-block"></i>
            </label>

            <!-- star 3 -->
            <input type="radio" id="3-star-rating" name="rating" value="3">
            <label for="3-star-rating" class="star-rating star" onclick="isClickStar(3)">
              <i class="fas fa-star d-inline-block"></i>
            </label>

            <!-- star 2 -->
            <input type="radio" id="2-star-rating" name="rating" value="2">
            <label for="2-star-rating" class="star-rating star" onclick="isClickStar(2)">
              <i class="fas fa-star d-inline-block"></i>
            </label>

            <!-- star 1 -->
            <input type="radio" id="1-star-rating" name="rating" value="1">
            <label for="1-star-rating" class="star-rating star" onclick="isClickStar(1)">
              <i class="fas fa-star d-inline-block"></i>
            </label>
          </div>

          <div class="mb-3">
            <label for="review_edit" class="col-form-label">Ulasan</label>
            <textarea class="form-control" name="review_edit" id="review_edit"></textarea>
            <div class="text-danger" id="message_edit_review"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-dark  mt-2" id="button_edit_review">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>