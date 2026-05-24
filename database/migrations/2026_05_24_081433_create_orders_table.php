<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->string('invoice_number')->unique();
    $table->enum('type', ['buy', 'rent']);
    $table->string('full_name');
    $table->string('email');
    $table->string('phone');
    $table->string('province');
    $table->string('city');
    $table->string('district');
    $table->string('postal_code');
    $table->date('rent_start')->nullable();
    $table->date('rent_end')->nullable();
    $table->foreignId('payment_method_id')
        ->constrained()
        ->cascadeOnDelete();
    $table->bigInteger('total');
    $table->enum('status', [
                'pending',
                'paid',
                'rejected'
            ])->default('pending');
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
