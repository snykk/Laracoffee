@extends('/layouts/auth')

@push('css-dependencies')
<link href="/css/auth.css" rel="stylesheet" />
@endpush

@section("content")
<div class="container pb-2">

    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">{{ $title }} Page</h1>
                        </div>

                        @if(session()->has('message'))
                        {!! session("message") !!}
                        @endif

                        <form class="user" method="post" action="/auth/register">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control @error('fullname') is-invalid @enderror"
                                  id="fullname" name="fullname" placeholder="Full Name" value="{{ @old(" fullname") }}">
                                @error('fullname')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                  id="username" name="username" placeholder="Username" value="{{ @old(" username") }}">
                                @error('username')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                  name="email" placeholder="Email Address" value="{{ @old(" email") }}">
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                      id="password" name="password" placeholder="Password" data-toggle="password">
                                    @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input type="password"
                                      class="form-control @error('password_confirmation') is-invalid @enderror"
                                      id="password_confirmation" name="password_confirmation"
                                      placeholder="Password Confirmation" data-toggle="password">
                                    @error('password_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="ml-2">Gender</div>
                            <div class="form-check ml-3">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="M" {{
                                  old('gender')=="M" ? 'checked' : '' }}>
                                <label class="form-check-label" for="male">
                                    Male
                                </label>
                            </div>
                            <div class="form-check ml-3">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="F" {{
                                  old('gender')=="F" ? 'checked' : '' }}>
                                <label class="form-check-label" for="female">
                                    Female
                                </label>
                                @error('gender')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                  name="phone" placeholder="Phone" value="{{ @old(" phone") }}">
                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                  id="address" name="address" placeholder="Address" value="{{ @old(" address") }}">
                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <input type="hidden" name="role_id" value="2" /> {{-- role 2 for customer --}}
                            <button type="submit" class="btn btn-info btn-block">
                                Submit
                            </button>
                        </form>

                        <hr>

                        <div class="text-center">
                            <a class="small" href="/auth/login">Already have account? Login now!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection