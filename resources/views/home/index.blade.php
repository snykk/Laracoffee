@extends('/layouts/main')

@section('content')

@push('css-dependencies')
    <link rel="stylesheet" type="text/css" href="/css/home.css" />
@endpush

@if(session()->has('message'))
    {!! session("message") !!}
@endif

@can('is_admin')
    @include('/partials/home_admin')
@else
    @include('/partials/home_customers')
@endcan
@endsection