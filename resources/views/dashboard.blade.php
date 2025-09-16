@extends('layouts.main')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <h3 class="mb-0">Ringkasan Kas</h3>
  <form method="get" class="d-flex align-items-center gap-2">
    <input type="month" name="month" class="form-control form-control-sm" style="max-width: 180px" value="{{ $month }}">
    <button class="btn btn-sm btn-primary">Terapkan</button>
  </form>
</div>

<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card card-stat shadow-sm">
      <div class="card-body">
        <div class="text-secondary">Pemasukan (Bulan Ini)</div>
        <div class="h4 fw-bold mt-1">Rp {{ number_format($totalIncome,0,',','.') }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card card-stat shadow-sm">
      <div class="card-body">
        <div class="text-secondary">Iuran Masuk</div>
        <div class="h5 fw-bold mt-1">Rp {{ number_format($iuranThisMonth,0,',','.') }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card card-stat shadow-sm">
      <div class="card-body">
        <div class="text-secondary">Pengeluaran</div>
        <div class="h5 fw-bold mt-1">Rp {{ number_format($expense,0,',','.') }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card card-stat shadow-sm">
      <div class="card-body">
        <div class="text-secondary">Saldo Bulan Ini</div>
        <div class="h4 fw-bold mt-1">Rp {{ number_format($saldo,0,',','.') }}</div>
      </div>
    </div>
  </div>
</div>

<div class="card mb-4 shadow-sm">
  <div class="card-body">
    <h5 class="card-title">Tren 12 Bulan</h5>
    <canvas id="trendChart" height="90"></canvas>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h5 class="card-title mb-0">Status Iuran {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->isoFormat('MMMM YYYY') }}</h5>
      <div class="text-muted small">Iuran per orang: Rp {{ number_format($monthlyDue,0,',','.') }}</div>
    </div>
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Telepon</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($members as $i => $m)
          @php $paid = isset($paidByMemberId[$m->id]); @endphp
          <tr class="{{ $paid ? 'table-success' : 'table-warning' }}">
            <td>{{ $i+1 }}</td>
            <td>{{ $m->name }}</td>
            <td>{{ $m->phone }}</td>
            <td>
              @if($paid)
                <span class="badge text-bg-success">Sudah Bayar</span>
              @else
                <span class="badge text-bg-warning">Belum</span>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
const labels = @json($labels);
const incomeSeries = @json($incomeSeries);
const expenseSeries = @json($expenseSeries);

new Chart(document.getElementById('trendChart'), {
  type: 'line',
  data: {
    labels: labels,
    datasets: [
      { label: 'Pemasukan', data: incomeSeries },
      { label: 'Pengeluaran', data: expenseSeries }
    ]
  }
});
</script>
@endpush
