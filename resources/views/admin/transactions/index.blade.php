@extends('layouts.main')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
<h4 class="mb-0">Transaksi Lain</h4>
<a class="btn btn-primary" href="{{ route('transactions.create') }}">Tambah</a>
</div>
@if(session('ok'))<div class="alert alert-success">{{ session('ok') }}</div>@endif
<div class="table-responsive">
<table class="table table-striped align-middle">
<thead>
<tr><th>#</th><th>Tanggal</th><th>Jenis</th><th>Judul</th><th>Kategori</th><th>Jumlah</th><th></th></tr>
</thead>
<tbody>
@foreach($tx as $i => $t)
<tr>
<td>{{ $tx->firstItem() + $i }}</td>
<td>{{ $t->date->format('d M Y') }}</td>
<td>
<span class="badge {{ $t->type==='income' ? 'text-bg-success' : 'text-bg-danger' }}">{{ ucfirst($t->type) }}</span>
</td>
<td>{{ $t->title }}</td>
<td>{{ $t->category }}</td>
<td>Rp {{ number_format($t->amount,0,',','.') }}</td>
<td class="text-end">
<form method="post" action="{{ route('transactions.destroy', $t) }}" onsubmit="return confirm('Hapus transaksi?')" class="d-inline">
@csrf @method('DELETE')
<button class="btn btn-sm btn-outline-danger">Hapus</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
{{ $tx->links() }}
@endsection