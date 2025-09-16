<?php
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class PaymentController extends Controller
{
public function index(Request $request)
{
$month = $request->query('month', now()->format('Y-m'));
$payments = Payment::with('member')
->where('month_year', $month)
->orderByJoin('member.name') // Laravel 11 helper; jika error, ganti ->join->orderBy
->paginate(25);


return view('admin.payments.index', compact('payments', 'month'));
}


public function create(Request $request)
{
$month = $request->query('month', now()->format('Y-m'));
$monthlyDue = config('kas.monthly_due');
$paidMemberIds = Payment::where('month_year', $month)->pluck('member_id');
$members = Member::whereNotIn('id', $paidMemberIds)->where('active', true)->orderBy('name')->get();


return view('admin.payments.create', compact('month', 'monthlyDue', 'members'));
}


public function store(Request $request)
{
$data = $request->validate([
'member_id' => ['required', Rule::exists('members', 'id')],
'month_year' => ['required', 'regex:/^\\d{4}-\\d{2}$/'],
'amount' => ['required', 'integer', 'min:0'],
'paid_at' => ['nullable', 'date'],
]);


$data['paid_at'] = $data['paid_at'] ?? now()->toDateString();


Payment::create($data); // unique(member_id, month_year) sudah lindungi duplikasi
return redirect()->route('payments.index', ['month' => $data['month_year']])->with('ok', 'Pembayaran dicatat.');
}


public function destroy(Payment $payment)
{
$month = $payment->month_year;
$payment->delete();
return redirect()->route('payments.index', ['month' => $month])->with('ok', 'Pembayaran dihapus.');
}
}