@extends('/layouts/auth')

@push('css-dependencies')
<link href="/css/auth.css" rel="stylesheet" />
@endpush

@section("content")
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">{{ $title }} Page</h1>
                                </div>

                                @if(session()->has('message'))
                                {!! session("message") !!}
                                @endif

                                <form class="user" method="post" action="/auth/login">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                          id="email" name="email" placeholder="Enter an email address" value="{{ @old("
                                          email") }}">
                                        @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password"
                                          class="form-control @error('password') is-invalid @enderror" id="password"
                                          name="password" placeholder="Password" data-toggle="password">
                                        @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-info btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>

                                <div class="text-center">
                                    <a class="small" href="/auth/register">Belum memiliki akun? Buat sekarang!</a>
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