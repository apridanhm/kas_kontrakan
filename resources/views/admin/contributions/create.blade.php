@extends('layouts.main')

@section('content')
<h4 class="mb-3">Tambah Pemasukan</h4>

@if ($errors->any())
  <div class="alert alert-danger"><ul class="mb-0">
    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
  </ul></div>
@endif

<form method="post" action="{{ route('contributions.store') }}" class="card card-body shadow-sm">
  @csrf
  <div class="row g-3">
    <div class="col-md-4">
      <label class="form-label">Kategori</label>
      <select name="income_category_id" id="income_category_id" class="form-select" required>
        <option value="">– pilih –</option>
        @foreach($cats as $c)
          <option value="{{ $c->id }}" data-default="{{ $c->default_amount ?? 0 }}" {{ ($selected && $selected->id==$c->id)?'selected':'' }}>
            {{ $c->name }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Anggota</label>
      <select name="member_id" class="form-select" required>
        <option value="">– pilih –</option>
        @foreach($members as $m)
          <option value="{{ $m->id }}">{{ $m->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2">
      <label class="form-label">Bulan</label>
      <input type="month" name="month_year" class="form-control" value="{{ $month }}" required>
    </div>
    <div class="col-md-2">
      <label class="form-label">Jumlah</label>
      <input type="number" name="amount" id="amount" class="form-control" min="0"
             value="{{ $selected? ($selected->default_amount ?? 0) : 0 }}" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Tgl Bayar</label>
      <input type="date" name="paid_at" class="form-control" value="{{ now()->toDateString() }}">
    </div>
    <div class="col-md-6">
      <label class="form-label">Keterangan (opsional)</label>
      <input type="text" name="note" class="form-control" value="{{ old('note') }}" placeholder="contoh: bayar patungan WiFi">
    </div>
  </div>

  <div class="mt-3 d-flex gap-2">
    <button class="btn btn-primary">Simpan</button>
    <a class="btn btn-link" href="{{ route('contributions.index', ['month'=>$month, 'category_id'=>$selected->id ?? null]) }}">Batal</a>
  </div>
</form>
@endsection

@push('scripts')
<script>
  const sel = document.getElementById('income_category_id');
  const amount = document.getElementById('amount');
  if (sel) sel.addEventListener('change', e => {
    const d = e.target.selectedOptions[0]?.getAttribute('data-default');
    if (d && parseInt(d) >= 0) amount.value = d;
  });
</script>
@endpush
