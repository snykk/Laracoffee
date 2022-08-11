@extends('/layouts/main')

@push('css-dependencies')
<link rel="stylesheet" type="text/css" href="/css/product.css" />
@endpush

@push('scripts-dependencies')
<script src="/js/product.js" type="module"></script>
@endpush

@section('content')
<div class="container-fluid p-4" style="background: #eee;">

  @include('/partials/breadcumb')

  @if(session()->has('message'))
  {!! session("message") !!}
  @endif

  <div class="row flex-lg-nowrap">

    <div class="col">
      <div class="row">
        <div class="col mb-3">
          <div class="card">
            <div class="card-body">
              <div class="e-profile">
                <div class="row">
                  <div class="col-12 col-sm-auto mb-3">
                    <img class="mb-2" id="image-preview" src="{{ asset('storage/' . $product->image) }}" width="200"
                      alt="{{ $product->product_name }}">
                  </div>
                  <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                    <div class="text-sm-left mb-2 mb-sm-0">
                      <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">
                        {{ $product->product_name }}
                      </h4>
                      <div class="text-muted"><small>Last updated at {{ date('d M Y', strtotime($product->updated_at))
                          }}
                        </small></div>
                      <div class="mt-2">
                        <!-- Form -->
                        <form id="form_edit_product" action="/product/edit_product/{{ $product->id }}" method="post"
                          enctype="multipart/form-data">
                          @csrf
                          <input type="hidden" name="oldImage" value="{{ $product->image }}">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image">
                            @error('image')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                          </div>
                      </div>
                    </div>
                    <div class="text-center">
                      <span
                        style="background: #108d6f; color:white; padding:0.08em 0.4em;border-radius: 0.5em;cursor:pointer">Admin</span>
                      <div class="text-muted"><small>Created at: {{ date('d M Y', strtotime($product->created_at)) }}
                        </small></div>
                    </div>
                  </div>
                </div>
                <ul class="nav nav-tabs">
                  <li class="nav-item"><a href="" class="active nav-link">Form of {{ $title }}</a></li>
                </ul>
                <div class="tab-content pt-3">
                  <div class="tab-pane active">
                    <div class="row">
                      <div class="col">
                        <div class="row">
                          <div class="col-12 col-sm-6 mb-3">
                            <div class="form-group">
                              <label for="product_name">Product Name</label>
                              <input class="form-control @error('product_name') is-invalid @enderror" type="text"
                                id="product_name" name="product_name" placeholder="Enter product name" value="{{ old("
                                product_name", $product->product_name) }}">
                              @error('product_name')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                          <div class="col-12 col-sm-2 mb-3">
                            <div class="form-group">
                              <label for="stock">Stock</label>
                              <input class="form-control @error('product_name') is-invalid @enderror" type="text"
                                id="stock" name="stock" placeholder="Enter available stock" value="{{ old(" stock",
                                $product->stock) }}">
                              @error('stock')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                          <div class="col-12 col-sm-2 mb-3">
                            <div class="form-group">
                              <label for="price">Price</label>
                              <input class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                                type="text" placeholder="Enter product price" value="{{ old(" price", $product->price)
                              }}">
                              @error('price')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                          <div class="col-12 col-sm-2 mb-3">
                            <div class="form-group">
                              <label for="discount">Discount</label>
                              <input class="form-control @error('discount') is-invalid @enderror" type="text"
                                id="discount" name="discount" placeholder="Masukkan price produk" value="{{ old("
                                discount", $product->discount) }}">
                              @error('discount')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col mb-3">
                            <div class="form-group">
                              <label for="orientation">Product Orientation</label>
                              <input class="form-control @error('orientation') is-invalid @enderror" id="orientation"
                                name="orientation" placeholder="Enter product orientation" value="{{ old(" orientation",
                                $product->orientation) }}">
                              @error('orientation')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col mb-3">
                            <div class="form-group">
                              <label for="description">Product Description</label>
                              <input class="form-control @error('description') is-invalid @enderror" id="description"
                                placeholder="Masukkan description produk" name="description" value="{{ old("
                                description", $product->description) }}">
                              @error('description')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class=" row">
                      <div class="col d-flex justify-content-end">
                        <a class="btn btn-primary mx-3" href="/product">Back to Product List</a>
                        <button class="btn btn-primary" type="submit" id="button_edit_product">Save Changes</button>
                      </div>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection