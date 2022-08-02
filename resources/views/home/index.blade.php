@extends('/layouts/main')

@section('content')

@if(session()->has('message'))
    {!! session("message") !!}
@endif

@can('is_admin')
    @include('/partials/home_admin')
@else
    @include('/partials/home_customers')
@endcan
@endsection