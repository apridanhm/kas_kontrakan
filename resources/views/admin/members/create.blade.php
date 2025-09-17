@extends('layouts.main')

@section('content')
<h4 class="mb-3">Tambah Anggota</h4>

@if ($errors->any())
  <div class="alert alert-danger"><ul class="mb-0">
    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
  </ul></div>
@endif

<form method="post" action="{{ route('members.store') }}" class="card card-body shadow-sm">
  @csrf
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Nama</label>
      <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">No. HP (opsional)</label>
      <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
    </div>
    <div class="col-12 form-check mt-2">
  {{-- kirim 0 saat checkbox tidak dicentang --}}
  <input type="hidden" name="active" value="0">
  <input type="checkbox"
         name="active"
         id="active"
         class="form-check-input"
         value="1"
         {{ old('active', '1') ? 'checked' : '' }}>
  <label for="active" class="form-check-label">Aktif</label>
</div>

  <div class="mt-3">
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('members.index') }}" class="btn btn-link">Batal</a>
  </div>
</form>
@endsection
