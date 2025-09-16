<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month', now()->format('Y-m'));
        $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end   = $start->copy()->endOfMonth();

        $membersCount = Member::count();
        $paidCount    = Payment::where('month_year', $month)->count();
        $unpaidCount  = max($membersCount - $paidCount, 0);

        $iuranThisMonth = Payment::where('month_year', $month)->sum('amount');
        $incomeOther    = Transaction::whereBetween('date', [$start, $end])->where('type','income')->sum('amount');
        $expense        = Transaction::whereBetween('date', [$start, $end])->where('type','expense')->sum('amount');
        $saldo          = ($iuranThisMonth + $incomeOther) - $expense;

        return view('admin.home', compact(
            'month', 'membersCount', 'paidCount', 'unpaidCount',
            'iuranThisMonth', 'incomeOther', 'expense', 'saldo'
        ));
    }
}
