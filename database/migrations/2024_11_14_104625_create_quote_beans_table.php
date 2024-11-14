<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('quote_beans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('bean_id')->constrained('coffee_beans');
        $table->integer('quantity')->default(1);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_beans');
    }
};
