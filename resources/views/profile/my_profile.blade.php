@extends('/layouts/main')

@push('css-dependencies')
<link href="/css/profile.css" rel="stylesheet" />
@endpush

@section('content')
<div class="main-body px-5">

    @include('/partials/breadcumb')

    <div class="row gutters-sm">
        <div class="col-md-4 mb-3">

            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="{{ asset('storage/' . auth()->user()->image) }}" width="150">
                        <div class="mt-3">
                            <h4>{{ auth()->user()->username }}</h4>
                            <p class="text-secondary mb-1">{{ auth()->user()->role->role_name }}</p>
                            <p class="text-muted font-size-sm">User since {{ auth()->user()->created_at->format('d M Y')
                                }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Full Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ auth()->user()->fullname }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ auth()->user()->email }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Phone</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ auth()->user()->phone }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Gender</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ auth()->user()->gender == "M" ? "Male" : "Female" }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Address</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ auth()->user()->address}}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <a class="btn btn-dark " href="/profile/edit_profile">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection