<?php
namespace Database\Seeders;


use App\Models\Member;
use Illuminate\Database\Seeder;


class MemberSeeder extends Seeder
{
public function run(): void
{
$names = ['Apridan','Fathur','Refa','Fikri','Fatih','Nurul'];
foreach ($names as $n) {
Member::firstOrCreate(['name' => $n], ['active' => true]);
}
}
}