@extends('layouts.main')
@section('content')
<h4 class="mb-3">Tambah Transaksi</h4>
<form method="post" action="{{ route('transactions.store') }}" class="card card-body shadow-sm">
@csrf
<div class="row g-3">
<div class="col-md-3">
<label class="form-label">Tanggal</label>
<input type="date" name="date" value="{{ now()->toDateString() }}" class="form-control" required>
</div>
<div class="col-md-3">
<label class="form-label">Jenis</label>
<select name="type" class="form-select" required>
<option value="income"  {{ (isset($prefillType) && $prefillType==='income')  ? 'selected' : '' }}>Pemasukan</option>
<option value="expense" {{ (isset($prefillType) && $prefillType==='expense') ? 'selected' : '' }}>Pengeluaran</option>
</select>
</div>
<div class="col-md-3">
<label class="form-label">Kategori</label>
<input name="category" class="form-control" placeholder="contoh: listrik, air, dll">
</div>
<div class="col-md-3">
<label class="form-label">Jumlah</label>
<input type="number" name="amount" min="0" class="form-control" required>
</div>
<div class="col-12">
<label class="form-label">Judul</label>
<input name="title" class="form-control" required>
</div>
<div class="col-12">
<label class="form-label">Deskripsi</label>
<textarea name="description" class="form-control" rows="3"></textarea>
</div>
</div>
<div class="mt-3">
<button class="btn btn-primary">Simpan</button>
<a href="{{ route('transactions.index') }}" class="btn btn-link">Batal</a>
</div>
</form>
@endsection