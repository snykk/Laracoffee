@extends('/layouts/main')

@push('css-dependencies')
<link href="/css/profile.css" rel="stylesheet" />
@endpush

@push('scripts-dependencies')
<script src="/js/profile.js" type="module"></script>
@endpush

@section('content')
<div class="main-body px-1 px-md-3 px-lg-4 px-xl-5">

    @include('/partials/breadcumb')

    <!-- flasher -->
    @if(session()->has('message'))
    {!! session("message") !!}
    @endif

    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->

            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img class="img-account-profile mb-2" id="image-preview" src="{{ asset('storage/' .
                      auth()->user()->image) }}" width="150" alt="">
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">Must be an image no more than 2 MB</div>
                    <!-- Profile picture upload button-->
                    <form method="post" action="/profile/edit_profile/{{ auth()->user()->id }}"
                      enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="oldImage" value="{{ auth()->user()->image }}">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image"
                              name="image">
                            @error('image')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Profile details card-->
            <div class="card mb-4">
                <div class="card-header">Profile Details</div>
                <div class="card-body">
                    <!-- Form Group (username)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="text"
                          placeholder="Enter your email address" value="{{ auth()->user()->email }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="username">Username <em class="link-danger">will show as your
                                identity in the website</em></label>
                        <input class="form-control @error('username') is-invalid @enderror" id="username"
                          name="username" type="text" placeholder="your username"
                          value="{{ auth()->user()->username }}">
                        @error('username')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="fullname">Full Name</label>
                        <input class="form-control @error('fullname') is-invalid @enderror" id="fullname"
                          name="fullname" type="text" placeholder="your fullname"
                          value="{{ auth()->user()->fullname }}">
                        @error('fullname')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row gx-3 mb-3">
                        <div class="col-md-6">
                            <label class="small mb-1" for="phone">No. HP</label>
                            <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                              type="text" placeholder="your phone" value="{{ auth()->user()->phone }}">
                            @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="small mb-1" for="gender">Gender</label>
                            <input class="form-control" id="gender" name="gender" type="text"
                              value="{{ auth()->user()->gender == " M" ? "Male" : "Female" }}"" readonly>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label for="name" class="col-sm-12 col-form-label">Address</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                              name="address" placeholder="Please enter your location"
                              value="{{ auth()->user()->address }}">
                            @error('address')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Save changes button-->
                    <div class="col-12 d-flex justify-content-start align-items-center">
                        <a href="/profile/my_profile" class="btn btn-outline-secondary me-2">Back</a>
                        <button class="btn btn-dark" type="submit">Save Changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection