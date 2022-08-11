@extends('/layouts/main')

@section('content')

@push('css-dependencies')
<link rel="stylesheet" type="text/css" href="/css/home.css" />
@endpush

<div class="mx-3">
    @if(session()->has('message'))
    {!! session("message") !!}
    @endif
</div>

@can('is_admin')
@include('/partials/home/home_admin')
@else
@include('/partials/home/home_customers')
@endcan
@endsection