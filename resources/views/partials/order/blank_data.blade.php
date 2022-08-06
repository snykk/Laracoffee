<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="text-center mt-4">
        <h1 class="display-1">?</h1>
        <p class="lead">No Data</p>
        @if (!isset($is_filtered))
        <p>No orders right now!</p>
        @else
        <p>No orders with status {{ $is_filtered }}</p>
        @endif

        @if (auth()->user()->id == 2)
        <a href="/product" class="link-info">
          <i class="fas fa-arrow-left me-1"></i>
          Buy some good product now
        </a>
        @else
        <a href="/order/order_history" class="link-info">
          <i class="fas fa-arrow-left me-1"></i>
          Wanna check order history?
        </a>
        @endif
      </div>
    </div>
  </div>
</div>