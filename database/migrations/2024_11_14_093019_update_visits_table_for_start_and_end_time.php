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
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn('visit_date'); // Verwijder de bestaande 'visit_date' kolom
            $table->time('start_time'); // Voeg 'start_time' toe
            $table->time('end_time'); // Voeg 'end_time' toe
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->date('visit_date')->nullable(); // Voeg 'visit_date' opnieuw toe als je de migratie wilt terugdraaien
            $table->dropColumn('start_time'); // Verwijder 'start_time'
            $table->dropColumn('end_time'); // Verwijder 'end_time'
        });
    }
};
