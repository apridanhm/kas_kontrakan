@extends('layouts.main')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
<h4 class="mb-0">Pembayaran Iuran</h4>
<div class="d-flex gap-2">
<form method="get" class="d-flex align-items-center gap-2">
<input type="month" name="month" class="form-control form-control-sm" value="{{ $month }}">
<button class="btn btn-sm btn-outline-secondary">Terapkan</button>
</form>
<a class="btn btn-primary" href="{{ route('payments.create', ['month' => $month]) }}">Catat Pembayaran</a>
</div>
</div>
@if(session('ok'))<div class="alert alert-success">{{ session('ok') }}</div>@endif
<div class="table-responsive">
<table class="table table-striped align-middle">
<thead>
<tr><th>#</th><th>Nama</th><th>Bulan</th><th>Tanggal Bayar</th><th>Jumlah</th><th></th></tr>
</thead>
<tbody>
@foreach($payments as $i => $p)
<tr>
<td>{{ $payments->firstItem() + $i }}</td>
<td>{{ $p->member->name }}</td>
<td>{{ $p->month_year }}</td>
<td>{{ optional($p->paid_at)->format('d M Y') }}</td>
<td>Rp {{ number_format($p->amount,0,',','.') }}</td>
<td class="text-end">
<form method="post" action="{{ route('payments.destroy', $p) }}" onsubmit="return confirm('Hapus pembayaran ini?')" class="d-inline">
@csrf @method('DELETE')
<button class="btn btn-sm btn-outline-danger">Hapus</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
{{ $payments->withQueryString()->links() }}
@endsection