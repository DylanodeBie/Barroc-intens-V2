<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('amount'); // Aantal producten
            $table->decimal('price', 10, 2); // Prijs per product
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_product');
    }
};
