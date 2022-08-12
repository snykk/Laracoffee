<nav aria-label="breadcrumb" class="main-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">{{ auth()->user()->role_id == 1 ? "Admin" : "Customer" }}</li>
    <li class="breadcrumb-item">{{ ucwords(explode("/",Request::path())[0])}}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
  </ol>
</nav>

<hr class="mt-0 mb-4">