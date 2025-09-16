@extends('layouts.main')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
<h4 class="mb-0">Anggota</h4>
<a href="{{ route('members.create') }}" class="btn btn-primary">Tambah</a>
</div>
@if(session('ok'))
<div class="alert alert-success">{{ session('ok') }}</div>
@endif
<div class="table-responsive">
<table class="table table-striped align-middle">
<thead><tr><th>#</th><th>Nama</th><th>Telepon</th><th>Aktif</th><th></th></tr></thead>
<tbody>
@foreach($members as $i => $m)
<tr>
<td>{{ $members->firstItem() + $i }}</td>
<td>{{ $m->name }}</td>
<td>{{ $m->phone }}</td>
<td>
@if($m->active)
<span class="badge text-bg-success">Aktif</span>
@else
<span class="badge text-bg-secondary">Nonaktif</span>
@endif
</td>
<td class="text-end">
<a class="btn btn-sm btn-outline-secondary" href="{{ route('members.edit', $m) }}">Edit</a>
<form action="{{ route('members.destroy', $m) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus anggota?')">
@csrf @method('DELETE')
<button class="btn btn-sm btn-outline-danger">Hapus</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
{{ $members->withQueryString()->links() }}
@endsection