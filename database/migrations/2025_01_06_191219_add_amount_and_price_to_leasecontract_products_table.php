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
        Schema::table('leasecontract_products', function (Blueprint $table) {
            $table->integer('amount')->nullable(); // Voeg de kolom 'amount' toe
            $table->decimal('price', 8, 2)->nullable(); // Voeg de kolom 'price' toe
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leasecontract_products', function (Blueprint $table) {
            $table->dropColumn(['amount', 'price']); // Verwijder de kolommen
        });
    }
};
