@extends('layouts.main')
@section('content')
<h4 class="mb-3">Edit Anggota</h4>
<form method="post" action="{{ route('members.update', $member) }}" class="card card-body shadow-sm">
@csrf @method('PUT')
<div class="row g-3">
<div class="col-md-6">
<label class="form-label">Nama</label>
<input name="name" class="form-control" value="{{ $member->name }}" required>
</div>
<div class="col-md-6">
<label class="form-label">Telepon</label>
<input name="phone" class="form-control" value="{{ $member->phone }}">
</div>
<input type="hidden" name="active" value="0">
<input type="checkbox" name="active" id="active" class="form-check-input" value="1"
       {{ old('active', $member->active ? '1' : '0') == '1' ? 'checked' : '' }}>
<label for="active" class="form-check-label">Aktif</label>

</div>
<div class="mt-3">
<button class="btn btn-primary">Update</button>
<a href="{{ route('members.index') }}" class="btn btn-link">Batal</a>
</div>
</form>
@endsection