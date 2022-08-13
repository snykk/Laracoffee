@extends('/layouts/main')

@push('css-dependencies')
<link rel="stylesheet" type="text/css" href="/css/home.css" />
@endpush

@can('is_admin')
@push('scripts-dependencies')
<script src="/js/sales_chart.js"></script>
<script src="/js/profits_chart.js"></script>
@endpush
@endcan

@section('content')

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