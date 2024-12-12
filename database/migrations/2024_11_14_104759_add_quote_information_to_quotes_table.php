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
        Schema::create('quote_machines', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('quote_id')->constrained('quotes')->onDelete('cascade'); // Foreign key to quotes table
            $table->foreignId('machine_id')->constrained('machines')->onDelete('cascade'); // Foreign key to machines table
            $table->integer('quantity')->default(1); // Quantity of machines
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_machines');
    }
};