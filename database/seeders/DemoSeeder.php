<?php
namespace Database\Seeders;


use App\Models\Member;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Database\Seeder;


class DemoSeeder extends Seeder
{
public function run(): void
{
$month = now()->format('Y-m');
$due = (int) config('kas.monthly_due');


$members = Member::all();
// Tandai beberapa sudah bayar
foreach ($members->take(3) as $m) {
Payment::updateOrCreate([
'member_id' => $m->id,
'month_year' => $month,
], [
'paid_at' => now()->toDateString(),
'amount' => $due,
]);
}


// Contoh pengeluaran
Transaction::create([
'date' => now()->toDateString(),
'type' => 'expense',
'category' => 'Listrik',
'title' => 'Bayar listrik bulan ini',
'description' => 'Tagihan listrik PLN',
'amount' => 250000,
]);
}
}