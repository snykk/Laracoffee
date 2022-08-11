@extends('/layouts/main')

@push('css-dependencies')
<link rel="stylesheet" type="text/css" href="/css/order.css" />
@endpush

@push('scripts-dependencies')
<script src="/js/order_data.js" type="module"></script>
@endpush

@push('modals-dependencies')
@include('/partials/order/order_detail_modal')
@include('/partials/order/reject_order_modal')
@include('/partials/order/transaction_proof_upload_modal')
@endpush

@section('content')
<div class="container">

  <!-- flasher -->
  @if(session()->has('message'))
  {!! session("message") !!}
  @endif

  <div class="panel panel-default panel-order">

    @include('/partials/order/filter')

    <div class="panel-body mt-3">
      @if (count($orders) > 0)

      @include('/partials/order/order_lists')

      @else

      @include('/partials/order/blank_data')

      @endif

    </div>
  </div>
</div>
@endsection