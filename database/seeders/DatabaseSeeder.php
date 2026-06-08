<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermisionSeeder::class,
            FaqSeeder::class,
            ProductSeeder::class,
            NewStockProductSeeder::class,
            PaymentMethodSeeder::class,
        ]);
    }
}