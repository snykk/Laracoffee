@extends('/layouts/main')

@push('css-dependencies')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
@endpush


@push('scripts-dependencies')
<script src="/js/transaction.js"></script>
<script src="/js/transaction_table.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
@endpush


@section('content')
<main>
  <div class="container-fluid px-4 mt-4">

    <!-- flasher -->
    @if(session()->has('message'))
    {!! session("message") !!}
    @endif

    @include('/partials/breadcumb')

    <div class="card mb-4">
      <div class="card-header">
        <i class="fas fa-fw fa-solid fa-money-check-dollar me-1"></i>
        Transaction
      </div>
      <div class="card-body">
        <table id="transaction_table">
          <thead>
            <tr>
              <th>Index </th>
              <th>Title</th>
              <th>Description</th>
              <th>Income</th>
              <th>Outcome</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Interface</th>
            </tr>
          </thead>
          <tbody>
            <a href="/transaction/add_outcome" title="add outcome" class="float-end mb-3"><button
                class='btn btn-secondary'>Add Outcome</button></a>

            @php
            $inc = 0
            @endphp
            @foreach ($transactions as $transaction)
            <tr>
              <td>
                {{ ++$inc }}
              </td>
              <td>
                {{ $transaction->category->category_name }}
              </td>
              <td>
                {{ $transaction->description }}
              </td>
              <td>
                {{$transaction->income ? $transaction->income : "----"}}
              </td>
              <td>
                {{$transaction->outcome ? $transaction->outcome : "----"}}
              </td>
              <td>
                {{$transaction->created_at->format('d-m-Y')}}
              </td>
              <td>
                {{$transaction->updated_at->format('d-m-Y')}}
              </td>
              <td>
                <button class="btn btn-secondary button_edit_transaction" data-transactionId="{{ $transaction->id }}"
                  data-isOutcome="{{ $transaction->outcome? '1' : '0' }}"><i class="fas fa-solid fa-marker"></i>
                </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
@endsection