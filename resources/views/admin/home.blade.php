@extends('layouts.main')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <h4 class="mb-0">Admin – Ringkasan</h4>
  <form method="get" class="d-flex align-items-center gap-2">
    <input type="month" name="month" class="form-control form-control-sm" value="{{ $month }}">
    <button class="btn btn-sm btn-outline-secondary">Terapkan</button>
  </form>
</div>

<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card shadow-sm"><div class="card-body">
      <div class="text-secondary">Anggota</div>
      <div class="h4 fw-bold mt-1">{{ $membersCount }}</div>
    </div></div>
  </div>
  <div class="col-md-3">
    <div class="card shadow-sm"><div class="card-body">
      <div class="text-secondary">Sudah Bayar</div>
      <div class="h4 fw-bold mt-1">{{ $paidCount }}</div>
    </div></div>
  </div>
  <div class="col-md-3">
    <div class="card shadow-sm"><div class="card-body">
      <div class="text-secondary">Belum Bayar</div>
      <div class="h4 fw-bold mt-1">{{ $unpaidCount }}</div>
    </div></div>
  </div>
  <div class="col-md-3">
    <div class="card shadow-sm"><div class="card-body">
      <div class="text-secondary">Saldo Bulan Ini</div>
      <div class="h4 fw-bold mt-1">Rp {{ number_format($saldo,0,',','.') }}</div>
    </div></div>
  </div>
</div>

<div class="row g-3">
  <div class="col-md-4">
    <div class="card shadow-sm"><div class="card-body">
      <h6 class="mb-2">Pembayaran Iuran</h6>
      <p class="mb-2 small text-muted">Iuran masuk: Rp {{ number_format($iuranThisMonth,0,',','.') }}</p>
      <div class="d-grid gap-2">
        <a class="btn btn-primary" href="{{ route('payments.create', ['month' => $month]) }}">➕ Tambah Pembayaran</a>
        <a class="btn btn-outline-secondary" href="{{ route('payments.index', ['month' => $month]) }}">Daftar Pembayaran</a>
      </div>
    </div></div>
  </div>

  <div class="col-md-4">
    <div class="card shadow-sm"><div class="card-body">
      <h6 class="mb-2">Transaksi Lain</h6>
      <p class="mb-2 small text-muted">Pemasukan lain: Rp {{ number_format($incomeOther,0,',','.') }} • Pengeluaran: Rp {{ number_format($expense,0,',','.') }}</p>
      <div class="d-grid gap-2">
        <a class="btn btn-success" href="{{ route('transactions.create', ['type' => 'income']) }}">➕ Tambah Pemasukan</a>
        <a class="btn btn-danger"  href="{{ route('transactions.create', ['type' => 'expense']) }}">➖ Tambah Pengeluaran</a>
        <a class="btn btn-outline-secondary" href="{{ route('transactions.index') }}">Daftar Transaksi</a>
      </div>
    </div></div>
  </div>

  <div class="col-md-4">
    <div class="card shadow-sm"><div class="card-body">
      <h6 class="mb-2">Anggota</h6>
      <div class="d-grid gap-2">
        <a class="btn btn-outline-primary" href="{{ route('members.index') }}">👥 Kelola Anggota</a>
        <a class="btn btn-outline-primary" href="{{ route('members.create') }}">➕ Tambah Anggota</a>
      </div>
    </div></div>
  </div>
</div>
@endsection
