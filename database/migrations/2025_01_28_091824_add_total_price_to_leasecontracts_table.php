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
        Schema::table('leasecontracts', function (Blueprint $table) {
            $table -> decimal('total_price', 8, 2) -> after('notice_period');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leasecontracts', function (Blueprint $table) {
            $table -> dropColumn('total_price');
        });
    }
};
