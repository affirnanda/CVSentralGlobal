<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Transfer BCA',
            'bank_name' => 'BCA',
            'account_number' => '1234567890',
            'account_name' => 'CV Sentral Global',
            'logo' => null,
            'is_active' => true,
        ];
    }
}