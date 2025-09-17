<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ config('app.name') }}</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<style>
.card-stat { border-radius: 16px; }
</style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="/">Kas Kontrakan</a>

    @if(request()->is('admin*'))
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.home') ? 'active' : '' }}" href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->is('admin/members*') ? 'active' : '' }}" href="{{ route('members.index') }}">Anggota</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->is('admin/payments*') ? 'active' : '' }}" href="{{ route('payments.index', ['month' => now()->format('Y-m')]) }}">Pembayaran</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->is('admin/transactions*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">Transaksi</a></li>
      </ul>
      <div class="d-flex gap-2">
        <a class="btn btn-sm btn-primary" href="{{ route('payments.create', ['month' => now()->format('Y-m')]) }}">+ Pembayaran</a>
        <a class="btn btn-sm btn-success" href="{{ route('transactions.create', ['type'=>'income']) }}">+ Pemasukan</a>
        <a class="btn btn-sm btn-danger"  href="{{ route('transactions.create', ['type'=>'expense']) }}">+ Pengeluaran</a>
      </div>
    @else
      <div class="d-flex gap-2">
        <a class="btn btn-sm btn-outline-secondary" href="/admin">Admin</a>
      </div>
    @endif
  </div>
</nav>




<main class="container my-4">
@yield('content')
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>