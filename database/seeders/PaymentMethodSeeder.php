<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::create([
            'name' => 'Transfer BCA',
            'bank_name' => 'BCA',
            'account_name' => 'CV Solusi Sentra Global Indo',
            'account_number' => '1234567890',
        ]);

        PaymentMethod::create([
            'name' => 'Transfer Mandiri',
            'bank_name' => 'Mandiri',
            'account_name' => 'CV Solusi Sentra Global Indo',
            'account_number' => '987654321',
        ]);
    }
}