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
        Schema::table('error_notifications', function (Blueprint $table) {
            $table->string('title')->after('user_id'); // Voeg de 'title' kolom toe na 'user_id'
            $table->text('description')->nullable()->after('title'); // Voeg de 'description' kolom toe na 'title'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('error_notifications', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('description');
        });
    }
};
