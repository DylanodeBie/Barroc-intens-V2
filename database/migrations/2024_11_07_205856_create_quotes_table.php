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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('pending'); // Status (e.g., pending, sent, accepted)
            $table->date('quote_date'); // Date of the quote
            $table->string('agreement_length')->nullable(); // Length of the agreement (e.g., "12 months")
            $table->string('maintenance_agreement')->nullable(); // Type of maintenance agreement
            $table->decimal('total_price', 8, 2)->nullable(); // Total price for the quote
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
