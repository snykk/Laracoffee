@extends('/layouts/main')

@push('css-dependencies')
<link rel="stylesheet" type="text/css" href="/css/order.css" />
@endpush

@section('content')
<div class="container">

  <!-- flasher -->
  @if(session()->has('message'))
  {!! session("message") !!}
  @endif

  <div class="panel panel-default panel-order">
    <div class="panel-heading d-flex justify-content-between align-items-center">
      <h1 class="main-title">
        <?= $title; ?>
      </h1>
      @if ($title == "Order Data")
      <div class="btn-group pull-right">
        <div class="btn-group">
          <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-bs-toggle="dropdown">Filter history
            <i class="fa fa-filter"></i></button>
          <ul class="dropdown-menu dropdown-menu-end">
            @foreach ($status as $item)
            @if ($item->id != "4")
            <a href="/order/order_data/{{ $item->id }}">
              <li class="dropdown-item">{{ $item->order_status }}
              </li>
            </a>
            @endif
            @endforeach
            <li>
              <hr class="dropdown-divider">
            </li>
            <a href="/order/order_data">
              <li class="dropdown-item">Show All
              </li>
            </a>
          </ul>
        </div>
      </div>
      @endif
    </div>

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