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
        Schema::create('invoices', function (Blueprint $table) {
    $table->id();
    $table->foreignId('customer_id')->constrained('customers');
    $table->foreignId('user_id')->constrained('users');
    $table->foreignId('quote_id')->nullable()->constrained('quotes'); // Optionele koppeling aan een offerte
    $table->date('invoice_date'); // Gebruik 'date' in plaats van 'string'
    $table->decimal('price', 10, 2); // Misschien verhogen voor grotere bedragen
    $table->boolean('is_paid')->default(false); // Standaard onbetaald
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
