@extends('layouts.main')
@section('content')
<h4 class="mb-3">Catat Pembayaran</h4>
<form method="post" action="{{ route('payments.store') }}" class="card card-body shadow-sm">
@csrf
<div class="row g-3">
<div class="col-md-5">
<label class="form-label">Anggota</label>
<select name="member_id" class="form-select" required>
<option value="">– pilih –</option>
@foreach($members as $m)
<option value="{{ $m->id }}">{{ $m->name }}</option>
@endforeach
</select>
</div>
<div class="col-md-3">
<label class="form-label">Bulan</label>
<input type="month" name="month_year" class="form-control" value="{{ $month }}" required>
</div>
<div class="col-md-2">
<label class="form-label">Jumlah</label>
<input type="number" name="amount" class="form-control" value="{{ $monthlyDue }}" min="0" required>
</div>
<div class="col-md-2">
<label class="form-label">Tgl Bayar</label>
<input type="date" name="paid_at" class="form-control" value="{{ now()->toDateString() }}">
</div>
</div>
<div class="mt-3">
<button class="btn btn-primary">Simpan</button>
<a href="{{ route('payments.index', ['month' => $month]) }}" class="btn btn-link">Batal</a>
</div>
</form>
@endsection