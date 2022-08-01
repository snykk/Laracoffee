@extends('/layouts/main')

@push('css-dependencies')
    <link href="/css/{{ $css }}.css" rel="stylesheet" /> 
@endpush

@section('content')
<div class="main-body">

    <!-- breadcumb -->
    <nav aria-label="breadcrumb" class="main-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Profile</li>
            <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
        </ol>
    </nav>

    <!-- end breadcumb -->

    <hr class="mt-0 mb-4">
    
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
                    <img class="img-account-profile mb-2" src="/img/profile-default.jpg" width="150" alt="">
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">[Jpg, Gif, Png] no more than 2 MB</div>
                    <!-- Profile picture upload button-->
                    <form method="post" action="/profile/edit_profile/{{ auth()->user()->id }}" enctype="multipart/form-data">
                    @csrf
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <!-- Form Group (username)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="text" placeholder="Enter your email address" value="{{ auth()->user()->email }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="username">Username (will show as identity in the website)</label>
                        <input class="form-control @error('username') is-invalid @enderror" id="username" name="username" type="text" placeholder="your username" value="{{ auth()->user()->username }}">
                        @error('username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="fullname">Full Name</label>
                        <input class="form-control @error('fullname') is-invalid @enderror" id="fullname" name="fullname" type="text" placeholder="your fullname" value="{{ auth()->user()->fullname }}">
                        @error('fullname')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row gx-3 mb-3">
                        <div class="col-md-6">
                            <label class="small mb-1" for="phone">No. HP</label>
                            <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" type="text" placeholder="your phone" value="{{ auth()->user()->phone }}">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="small mb-1" for="gender">Gender</label>
                            <input class="form-control" id="gender" name="gender" type="text" value="{{ auth()->user()->gender == "M" ? "Male" : "Female" }}"" readonly>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label for="name" class="col-sm-12 col-form-label">Address</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Please enter your location" value="{{ auth()->user()->address }}">
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Save changes button-->
                    <button class="btn btn-dark" type="submit">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
