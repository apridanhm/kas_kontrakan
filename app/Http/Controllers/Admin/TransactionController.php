<?php
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;


class TransactionController extends Controller
{
public function index()
{
$tx = Transaction::orderBy('date', 'desc')->paginate(25);
return view('admin.transactions.index', compact('tx'));
}


public function create()
{
return view('admin.transactions.create');
}


public function store(Request $request)
{
$data = $request->validate([
'date' => ['required', 'date'],
'type' => ['required', 'in:income,expense'],
'category' => ['nullable', 'string', 'max:50'],
'title' => ['required', 'string', 'max:100'],
'description' => ['nullable', 'string'],
'amount' => ['required', 'integer', 'min:0'],
]);


Transaction::create($data);
//return redirect()->route('transactions.index')->with('ok', 'Transaksi tersimpan.');
$prefillType = in_array($request->query('type'), ['income','expense']) ? $request->query('type') : 'expense';
return view('admin.transactions.create', compact('prefillType'));
}


public function destroy(Transaction $transaction)
{
$transaction->delete();
return back()->with('ok', 'Transaksi dihapus.');
}
}
