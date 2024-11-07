<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyRoleIdColumnInUsersTableSetDefault extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Voeg een standaardwaarde toe voor de role_id kolom
            $table->unsignedBigInteger('role_id')->default(1)->change(); // Standaard rol is 'Geen Rol' met id 1
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Verwijder de standaardwaarde en maak de kolom nullable (of verander dit afhankelijk van je vereisten)
            $table->unsignedBigInteger('role_id')->nullable(false)->change();
        });
    }
}
