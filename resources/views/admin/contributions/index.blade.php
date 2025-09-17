@extends('layouts.main')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <h4 class="mb-0">Pemasukan</h4>
  <div class="d-flex gap-2">
    <a class="btn btn-primary"
       href="{{ route('contributions.create', ['month'=>$month, 'category_id'=>$categoryId]) }}">+ Tambah</a>
  </div>
</div>

<form method="get" class="row g-2 mb-3">
  <div class="col-auto">
    <input type="month" name="month" class="form-control" value="{{ $month }}">
  </div>
  <div class="col-auto">
    <select name="category_id" class="form-select">
      <option value="">Semua Kategori</option>
      @foreach($cats as $c)
        <option value="{{ $c->id }}" {{ $categoryId==$c->id?'selected':'' }}>{{ $c->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-auto"><button class="btn btn-outline-secondary">Terapkan</button></div>
  <div class="col-auto align-self-center">
    Total: <strong>Rp {{ number_format($total,0,',','.') }}</strong>
  </div>
</form>

@if(session('ok'))<div class="alert alert-success">{{ session('ok') }}</div>@endif

<div class="table-responsive">
  <table class="table table-striped align-middle">
    <thead>
    <tr><th>#</th><th>Anggota</th><th>Kategori</th><th>Bulan</th><th>Tgl Bayar</th><th>Jumlah</th><th>Keterangan</th><th class="text-end">Aksi</th></tr>
    </thead>
    <tbody>
    @foreach($contribs as $i => $p)
      <tr>
        <td>{{ $contribs->firstItem() + $i }}</td>
        <td>{{ $p->member->name }}</td>
        <td>{{ $p->category->name }}</td>
        <td>{{ $p->month_year }}</td>
        <td>{{ optional($p->paid_at)->format('d M Y') }}</td>
        <td>Rp {{ number_format($p->amount,0,',','.') }}</td>
        <td>{{ $p->note }}</td>
        <td class="text-end">
          <form class="d-inline" method="post" action="{{ route('contributions.destroy',$p) }}"
                onsubmit="return confirm('Hapus pemasukan ini?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger">Hapus</button>
          </form>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>

{{ $contribs->withQueryString()->links() }}
@endsection
