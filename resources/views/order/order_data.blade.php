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
            <a href="/order/order_data/1">
              <li class="dropdown-item">Approved
              </li>
            </a>
            <a href="/order/order_data/2">
              <li class="dropdown-item">Pending</li>
            </a>
            <a href="/order/order_data/3">
              <li class="dropdown-item">Ditolak</li>
            </a>
            <a href="/order/order_data/5">
              <li class="dropdown-item">Canceled</li>
            </a>
            <li>
              <hr class="dropdown-divider">
            </li>
            <a href="/order/order_data">
              <li class="dropdown-item">Show All</li>
            </a>
          </ul>
        </div>
      </div>
      @endif
    </div>

    <div class="panel-body mt-3">

      <!-- Order Data -->
      @foreach ($orders as $row)
      <div class="row">
        <div class="col-md-1">
          <img src="{{ asset('storage/'. $row->product->image) }}" class="media-object img-thumbnail" />
          <div class="detail-pemesanan"><a class="detail_data_pemesanan" data-bs-toggle="modal"
              data-bs-target="#ModalDetailDataPemesanan" title="detail pemesanan" style="cursor: pointer;"
              data-id="<?= $row[" id_pemesanan"]; ?>" data-dipesan="{{ $row->created_at->format('d M Y') }}">detail
            </a></div>
        </div>
        <div class="col-md-11">
          <div class="row">
            <div class="col-md-12">
              <div class="float-end">
                <label class="badge bg-{{ $row->status->style }}">
                  {{ $row->status->order_status }}
                </label>
              </div>
              <span>
                <strong>
                  {{ $row->product->product_name }}
                </strong></span> <span class="badge bg-primary">
                {{ $row->payment->payment_method }}
              </span><br />
              Kuantitas :
              {{ $row->quantity }}, Total harga: Rp.
              {{ $row->total_price }} <br />
              <small>Catatan:
                {{ (isset($row->refusal_reason)) ? $row->refusal_reason : $row->note->order_notes }}
              </small><br>

              @if ($row->payment->payment_method == "Transfer Bank" && auth()->user()->id == 2)
              <small>Action </small>
              <a data-bs-placement="top" class="iniUploadBukti" data-bs-toggle="modal" data-id="{{ $row->id }}"
                data-bs-target="
                {{  ($row->status_id !=2) ? " #ModalUploadBuktiDitolak" : "#ModalUploadBukti" ; }}"
                title="Sent transfer evidance">
                <div class="btn btn-danger btn-xs fa fa-fw fa-camera label-bukti"
                  style="font-size: 0.75rem;padding:0.3rem; color:white">
                </div>
              </a>
              @endif

              @if (isset($row->product_id) && auth()->user()->id == 2 && $row->is_done == 1)
              <div>
                <a href="<?= base_url("ulasan?id_produk=") . $row[" id_produk"]; ?>" class="link-info"
                  style="text-decoration: none; font-size:0.9rem;">
                  Review Now!
                </a>
              </div>
              @endif
            </div>
            @php
            if (auth()->user()->id == 1) {
            $dest = "home/customers?username=" . $row["username"];
            }
            else {
            $dest = "profile/user_profile";
            }
            @endphp

            @if ($row->is_done == '1')
            <div class="col-md-12">pesanan diakhiri pada
              {{ $row->updated_at->format('d M Y') }}
              oleh <span class="link-danger" style="cursor: pointer;">@admin</span>
            </div>
            @else
            <div class="col-md-12">pesanan dibuat pada
              {{ $row->created_at->format('d M Y') }}
              oleh <a href="{{ $dest }}" style="text-decoration:none;">{{ "@" . auth()->user()->username }}</a>
            </div>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection