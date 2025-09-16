<?php
namespace App\Http\Controllers;


use App\Models\Member;
use App\Models\Payment;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
public function index(Request $request)
{
$monthParam = $request->query('month'); // format YYYY-MM
$month = $monthParam ?: now()->format('Y-m');


$start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
$end = Carbon::createFromFormat('Y-m', $month)->endOfMonth();


// Ringkasan bulan terpilih
$iuranThisMonth = Payment::where('month_year', $month)->sum('amount');


$incomeOther = Transaction::whereBetween('date', [$start, $end])
->where('type', 'income')
->sum('amount');


$expense = Transaction::whereBetween('date', [$start, $end])
->where('type', 'expense')
->sum('amount');


$totalIncome = $iuranThisMonth + $incomeOther;
$saldo = $totalIncome - $expense;


// Status pembayaran anggota
$members = Member::orderBy('name')->get();
$paidByMemberId = Payment::where('month_year', $month)
->pluck('id', 'member_id');


// Data 12 bulan terakhir
$labels = [];
$incomeSeries = [];
$expenseSeries = [];


for ($i = 11; $i >= 0; $i--) {
$m = now()->copy()->subMonths($i)->format('Y-m');
$s = Carbon::createFromFormat('Y-m', $m)->startOfMonth();
$e = $s->copy()->endOfMonth();


$iuran = Payment::where('month_year', $m)->sum('amount');
$inc = Transaction::whereBetween('date', [$s, $e])->where('type', 'income')->sum('amount');
$exp = Transaction::whereBetween('date', [$s, $e])->where('type', 'expense')->sum('amount');


$labels[] = $s->isoFormat('MMM YYYY');
$incomeSeries[] = $iuran + $inc;
$expenseSeries[] = $exp;
}


return view('dashboard', [
'month' => $month,
'start' => $start,
'end' => $end,
'totalIncome' => $totalIncome,
'iuranThisMonth' => $iuranThisMonth,
'incomeOther' => $incomeOther,
'expense' => $expense,
'saldo' => $saldo,
'members' => $members,
'paidByMemberId' => $paidByMemberId,
'labels' => $labels,
'incomeSeries' => $incomeSeries,
'expenseSeries' => $expenseSeries,
'monthlyDue' => config('kas.monthly_due'),
]);
}
}