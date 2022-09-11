@extends('/layouts/main')

@section('content')
<div class="container-fluid pt-4">

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
                <ul class="nav nav-tabs">
                  <li class="nav-item"><a href="" class="active nav-link">Form of {{ $title }}</a></li>
                </ul>

                <!-- Form -->
                <form action="/transaction/add_outcome" method="post">
                  @csrf
                  <div class="tab-content pt-3">
                    <div class="tab-pane active">
                      <div class="row">
                        <div class="col">
                          <div class="row">
                            <div class="col-12 col-sm-8 mb-3">
                              <div class="form-group">
                                <label for="category">Category</label>
                                <select class="form-control" name="category_id" id="category">
                                  <option value="0">Select Category</option>
                                  @foreach ($categories as $category)
                                  <option value="{{ $category->id }}" {{ old("category_id")==$category->id ? "selected"
                                    : "" }}>{{ $category->category_name }}</option>
                                  @endforeach
                                </select>
                                @error('category_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                              </div>
                            </div>
                            <div class="col-12 col-sm-4 mb-3">
                              <div class="form-group">
                                <label for="outcome">Total Outcome</label>
                                <input class="form-control" type="text" id="outcome" name="outcome"
                                  placeholder="Enter outcome" value="{{ old('outcome') }}">
                                @error('outcome')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col mb-3">
                              <div class="form-group">
                                <label for="description">Description</label>
                                <input class="form-control" id="description" name="description"
                                  placeholder="Masukkan description outcome" value="{{ old('description') }}">
                                @error('description')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col d-flex justify-content-end">
                          <a class="btn btn-secondary mx-3" href="/transaction">Back to Transaction List</a>
                          <button class="btn btn-dark" type="submit">Submit</button>
                        </div>
                      </div>
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
@endsection