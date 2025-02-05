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
        Schema::table('users', function (Blueprint $table) {
            // Maak de role_id nullable
            $table->foreignId('role_id')->constrained('roles')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Verwijder de foreign key als je deze migratie wilt terugdraaien
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
