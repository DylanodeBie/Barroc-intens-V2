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
            $table->text('approval_reason')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('approved_by')->nullable();
            $table->text('rejected_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leasecontracts', function (Blueprint $table) {
            $table->dropColumn('approval_reason');
            $table->dropColumn('rejection_reason');
            $table->dropColumn('approved_by');
            $table->dropColumn('rejected_by');
        });
    }
};
