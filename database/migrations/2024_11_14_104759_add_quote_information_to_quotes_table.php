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
            $table->id();
            $table->foreignId('quote_id')->constrained('quotes')->onDelete('cascade');
            $table->foreignId('machine_id')->constrained('machines');
            $table->integer('quantity');
            $table->timestamps();
        });

        Schema::create('quote_beans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained('quotes')->onDelete('cascade');
            $table->foreignId('bean_id')->constrained('coffee_beans');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_machines');
        Schema::dropIfExists('quote_beans');
    }
};
