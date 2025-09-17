<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IncomeCategory;

class IncomeCategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'Patungan Makan'],
            ['name' => 'Patungan WiFi'],
            ['name' => 'Patungan Listrik'],
        ] as $c) {
            IncomeCategory::firstOrCreate(['name' => $c['name']], $c);
        }
    }
}
