@extends('/layouts/main')

@push('css-dependencies')
<link rel="stylesheet" type="text/css" href="/css/order.css" />
@endpush

@section('content')
<div class="container">
  <h1 class="main-title">
    {{ $title }}
  </h1>
  <div class="row">
    <!-- Left -->
    <div class="col-lg-9">
      <div class="accordion" id="accordionMain">


        <!-- top field -->
        <div class="accordion-item mb-3 px-4 py-3">
          <form action="/order/make_order/{{ $product->id }}" method="post"></form>
          @csrf

          <!-- hidden input -->
          <input type="hidden" name="product_id" value="{{ old('product_id', $product->id) }}">

          <div class="row mb-3">
            <div class="col-md-8">
              <div class="form-group">
                <label for="product_name">Product Name</label>
                <input id="product_name" name="product_name" value="{{ $product->product_name }}" type="text"
                  class="form-control" disabled>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="price">Price per pieces</label>
                @if ($product->discount == 0)
                <input type="hidden" id="price" name="price" data-trueHarga="{{ old('price', $product->price) }}" value="Rp.
                {{ old('price', $product->price) }}" type="text" class="form-control" disabled>
                @else
                <input type="hidden" id="price" name="price"
                  data-trueHarga="{{ old('price', ((100 - $product->discount)/100) *$product->price) }}"
                  value="Rp. {{ old('price', ((100 - $product->discount)/100) *$product->price) }}" type="text"
                  class="form-control" disabled>
                @endif
                <div class="input-group" style="display:unset;">
                  <div class="input-group-prepend">
                    @if ($product->discount == 0)
                    <span class="input-group-text">
                      {{ $product->price }}
                    </span>
                    @else
                    <span class="input-group-text">Rp. {{ ((100 - $product->discount)/100) * $product->price }} <span
                        class="strikethrough ms-4">
                        {{ $product->price }}
                      </span><sup><sub class="mx-1">of</sub>
                        {{ $product->discount }}%
                      </sup>
                    </span>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group col-2">
            <label for="quantity">Quantity</label>
            <input id="quantity" name="quantity" data-idProduk="{{ $product->id }}" value=" {{ old('quantity', '0' ) }}"
              type=" number" min="0" class="form-control @error('quantity') is-invalid @enderror"
              onchange="myCounter()">
          </div>
          <div class="mb-3 col-12">
            @error('quantity')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="row mb-3">
            <div class="col-12">Destination</div>
            <div class="form-group col-7">
              <select class="form-control  @error('province') is-invalid @enderror" id="select_provinsi"
                name="province">
                <option value="{{ old('province', '0') }}" selected="selected">Select Province</option>
              </select>
              @error('province')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group col-5">
              <select class="form-control  @error('quantity') is-invalid @enderror" id="select_kota" disabled
                name="city">
                <option value="{{ old('city', '0') }}" selected="selected">Select City</option>
              </select>
              @error('city')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="alamat">Address Detail</label>
            <input id="alamat" name="alamat" type="text" class="form-control @error('address') is-invalid @enderror"
              value="{{ old('address', auth()->user()->address) }}">
            @error('address')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <!-- Online Banking -->
        <div class="accordion-item mb-3 ">
          <h2 class="h5 px-4 py-3 accordion-header d-flex justify-content-between align-items-center">
            <div class="form-check w-100 collapsed">
              <input class="form-check-input" type="radio" name="metode_id" id="online_bank" data-bs-toggle="collapse"
                data-bs-target="#collapseCC" aria-expanded="false" value="1" {{ old('metode_id')=='1' ? 'checked' : ''
                }}>
              <label class="form-check-label pt-1" for="online_bank" data-bs-toggle="collapse"
                data-bs-target="#collapseCC" aria-expanded="false">
                Transfer Bank
              </label>
              @error('metode_id')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>
            <span>
              <img src="{{ asset('storage/icons/online-banking.png') }}" height="50px" alt="logo online banking">
            </span>
          </h2>
          <div id="collapseCC" class="accordion-collapse collapse show" data-bs-parent="#accordionMain">
            <div class="accordion-body">
              <div>Pilih Bank:</div>
              <div id="mandiri" class="form-check w-100 collapsed">
                <span><img src="{{ asset('storage/icons/bank-mandiri.svg') }}" alt="mandiri logo" width="40px"></span>
                <input type="radio" id="bank_mandiri" class="bank" name="bank_id" value="1" {{ old('bank_id')=='1'
                  ? 'checked' : '' }} style="appearance: none;">
                <label for="bank_mandiri" class="colapse_pilih_bank" data-bs-toggle="collapse"
                  data-bs-target="#section_mandiri" aria-expanded="false" style="cursor: pointer;">Bank Mandiri</label>
                <div id="section_mandiri" class="accordion-collapse collapse show collapse-pilih-bank"
                  data-bs-parent="#collapseCC">
                  <!-- collapse pilih bank -->
                  <div class="divider"></div>
                  <div class="d-flex justify-content-between">
                    <small class="rek-title">No. Rekening Admin: </small>
                    <small class="rek-title">Atas Nama: </small>
                  </div>
                  <div class="d-flex justify-content-between mt-1">
                    <small class="no-rek">092 7840 1923 7422</small>
                    <small class="salin-rek">Elvin Raty P.</small>
                  </div>
                  <div class="divider"></div>
                  <small class="note">Akan dicek dalam 10 menit setelah pembayaran berhasil</small>
                </div>
              </div>
              <div id="bri" class="form-check w-100 collapsed">
                <span><img src="{{ asset('storage/icons/bank-bri.svg') }}" alt="bri logo" width="40px"
                    height="20px"></span>
                <input type="radio" id="bank_bri" class="bank" name="bank_id" value="2" {{ old('bank_id')=='2'
                  ? 'checked' : '' }} style="appearance: none;">
                <label for="bank_bri" class="colapse_pilih_bank" data-bs-toggle="collapse" data-bs-target="#section_bri"
                  aria-expanded="false" style="cursor: pointer;">Bank Bri</label>
                <div id="section_bri" class="accordion-collapse collapse fade collapse-pilih-bank"
                  data-bs-parent="#collapseCC">
                  <!-- collapse pilih bank -->
                  <div class="divider"></div>
                  <div class="d-flex justify-content-between">
                    <small class="rek-title">No. Rekening Admin: </small>
                    <small class="rek-title">Atas Nama: </small>
                  </div>
                  <div class="rek-content d-flex justify-content-between mt-1">
                    <small class="no-rek">058 9092 8274 9125</small>
                    <small class="salin-rek">Elvin Raty P.</small>
                  </div>
                  <div class="divider"></div>
                  <small class="note">Akan dicek dalam 10 menit setelah pembayaran berhasil</small>
                </div>
              </div>
              <div id="bca" class="form-check w-100 collapsed">
                <span><img src="{{ asset('storage/icons/bank-bca.svg') }}" alt="bca logo" width="40px"></span>
                <input type="radio" id="bank_bca" class="bank" name="bank_id" value="3" {{ old('bank_id')=='3'
                  ? 'checked' : '' }} style="appearance: none;">
                <label for="bank_bca" class="colapse_pilih_bank" data-bs-toggle="collapse" data-bs-target="#section_bca"
                  aria-expanded="false" style="cursor: pointer;">Bank BCA</label>
                <div id="section_bca" class="accordion-collapse collapse fade collapse-pilih-bank"
                  data-bs-parent="#collapseCC">
                  <!-- collapse pilih bank -->
                  <div class="divider"></div>
                  <div class="d-flex justify-content-between">
                    <small class="rek-title">No. Rekening Admin: </small>
                    <small class="rek-title">Atas Nama: </small>
                  </div>
                  <div class="rek-content d-flex justify-content-between mt-1">
                    <small class="no-rek">088 7182 4291 9123</small>
                    <small class="salin-rek">Elvin Raty P.</small>
                  </div>
                  <div class="divider"></div>
                  <small class="note">Akan dicek dalam 10 menit setelah pembayaran berhasil</small>
                </div>
              </div>
              <div id="bni" class="form-check w-100 collapsed">
                <span><img src="{{ asset('storage/icons/bank-bni.svg') }}" alt="bni logo" width="40px"></span>
                <input type="radio" id="bank_bni" class="bank" name="bank_id" value="4" {{ old('bank_id')=='4'
                  ? 'checked' : '' }} style="appearance: none;">
                <label for="bank_bni" class="colapse_pilih_bank" data-bs-toggle="collapse" data-bs-target="#section_bni"
                  aria-expanded="false" style="cursor: pointer;">Bank BNI</label>
                <div id="section_bni" class="accordion-collapse collapse fade collapse-pilih-bank"
                  data-bs-parent="#collapseCC">
                  <!-- collapse pilih bank -->
                  <div class="divider"></div>
                  <div class="d-flex justify-content-between">
                    <small class="rek-title">No. Rekening Admin: </small>
                    <small class="rek-title">Atas Nama: </small>
                  </div>
                  <div class="rek-content d-flex justify-content-between mt-1">
                    <small class="no-rek">098 2937 9823 2341</small>
                    <small class="salin-rek">Elvin Raty P.</small>
                  </div>
                  <div class="divider"></div>
                  <small class="note">Akan dicek dalam 10 menit setelah pembayaran berhasil</small>
                </div>
              </div>

              <!-- petunjuk -->
              <div class="container mt-3" id="container-petunjuk">
                <div class="accordion" id="accordionPetunjuk">
                  <div class="item">
                    <div class="item-header" id="headingTwo">
                      <h2 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between align-items-center"
                          type="button" data-bs-toggle="collapse" data-bs-target="#transfer-mbanking"
                          aria-expanded="false" aria-controls="transfer-mbanking">
                          <div class="title-accordion-petunjuk">Petunjuk transfer mBanking</div>
                          <img class="title-accordion-petunjuk" src="{{ asset('storage/icons/angle-down.svg') }}"
                            alt="angle down fas icon" width="18px">
                        </button>
                      </h2>
                    </div>
                    <div id="transfer-mbanking" class="collapse" aria-labelledby="headingTwo"
                      data-bs-parent="#accordionPetunjuk">
                      <div class="t-p">
                        <ol>
                          <li>Pilih m-transfer > antar rekening</li>
                          <li>Masukkan [No. Rekening Admin] beserta jumlah uang</li>
                          <li>klik <strong>send</strong></li>
                          <li>Masukkan pin mBanking anda dan pilih "OK"</li>
                        </ol>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <div class="item-header" id="headingFour">
                      <h2 class="mb-0">
                        <button class="btn btn-link collapsed d-flex justify-content-between align-items-center"
                          type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false"
                          aria-controls="collapseFour">
                          <div class="title-accordion-petunjuk">Petunjuk transfer ATM</div>
                          <img class="title-accordion-petunjuk" src="{{ asset('storage/icons/angle-down.svg') }}"
                            alt="angle down fas icon" width="18px">
                        </button>
                      </h2>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                      data-bs-parent="#accordionPetunjuk">
                      <div class="t-p">
                        <ol>
                          <li>Masukkan kartu ATM ke slot mesin ATM</li>
                          <li>Masukkan nomor PIN</li>
                          <li>Pilih jenis transaksi transfer</li>
                          <li>Pilih tujuan transfer
                            <ul>
                              <li>Pilih <strong>Transfer Sesama Bank</strong> apabila nomor rekening tujuan berasal dari
                                bank yang sama dengan anda, kemudian masukkan nomor rekening, lalu pilih Benar.</li>
                              <li>Pilih <strong>Transfer Antar Bank</strong> apabila nomor rekening tujuan berasal dari
                                bank yang berbeda dengan anda. Kemudian masukkan kode bank terkait dan nomor rekening
                                tujuan, lalu pilih Benar.</li>
                            </ul>
                          </li>
                          <li>Masukkan jumlah transfer</li>
                          <li>Transaksi berhasil diproses</li>
                          <li>Menunggu konfirmasi. Pilih Ya jika ingin melanjutkan atau pilih Tidak jika ingin
                            menyudahi.</li>
                          <li>Tunggu bukti transfer</li>
                        </ol>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="accordion-item mb-3 border">
          <h2 class="h5 px-4 py-3 accordion-header d-flex justify-content-between align-items-center">
            <div class="form-check w-100 collapsed">
              <input class="form-check-input" type="radio" name="metode_id" id="cod" data-bs-toggle="collapse"
                data-bs-target="#collapsePP" aria-expanded="false" value="2" {{ old('metode_id')=='2' ? 'checked' : ''
                }}>
              <label class="form-check-label pt-1" for="cod" data-bs-toggle="collapse" data-bs-target="#collapsePP"
                aria-expanded="false">
                Cash on Delivery
              </label>
              @error('metode_id')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>
            <span>
              <img src="{{ asset('storage/icons/cash-on-delivery.png') }}" height="50px" alt="logo COD" />
            </span>
          </h2>
          <div id="collapsePP" class="accordion-collapse collapse" data-bs-parent="#accordionMain">
            <div class="accordion-body">
              <div class="content-cod">
                <div class="note-cod">Note: gunakan metode ini jika ingin melakukan transaksi secara COD</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Right -->
    <div class="col-lg-3">
      <div class="card position-sticky top-0">
        <div class="p-3 bg-light bg-opacity-10">
          <h6 class="card-title mb-3">Order Summary</h6>
          <div class="d-flex justify-content-between mb-1 small">
            <span>Subtotal</span> <span><span>Rp. </span> <span id="sub-total">0</span></span>
          </div>
          <div class="d-flex justify-content-between mb-1 small">
            <span>Ongkir</span> <span><span>Rp. </span><span id="ongkir" data-valueOngkir="0">0</span></span>
          </div>

          <input type="hidden" name="kuponUsed" id="kuponUsed">

          <div class="d-flex justify-content-between mb-1 small">
            <span>Kupon
              @if (auth()->user()->coupon == 0)
              (no coupon)
              @else
              <span class="align-items-center">
                <label for="gunakan_kupon">Use</label>
              </span>
              <span>
                <input id="gunakan_kupon" type="checkbox" onchange="changeKuponStatus()">
              </span>
              )
              @endif
            </span><span><span></span><span id="kupon" data-valueKupon="{{ auth()->user()->coupon }}">
                {{ auth()->user()->coupon }} Coupon
              </span></span>
          </div>
          @if (auth()->user()->coupon != 0)
          <div class="d-flex justify-content-between mb-1 small text-danger">
            <span>Coupon used</span> <span><span id="kuponUsedShow">0 coupon</span></span>
          </div>
          @endif
          <hr>
          <div class="d-flex justify-content-between mb-4 small">
            <span>TOTAL</span> <strong class="text-dark"><span>Rp. </span><span id="total">0</span></strong>
            <input type="hidden" name="input_total" id="input_total" value="{{ old('input_total') }}">
          </div>
          <div class="form-group small mb-3">
            Pastikan anda benar-benar paham terkait pesanan yang anda buat. Jika ingin mendapatkan infor lebih lanjut
            silahkan hubungi <a class="link-danger"
              href="https://wa.me/6281230451084?text=Saya%20ingin%20menanyakan%20detail%20terkait%20produk%20anda"
              target="_blank" style="text-decoration: none;">@admin</a>
          </div>
          <button type="submit" class="btn btn-primary w-100 mt-2">Submit</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection