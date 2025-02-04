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
        Schema::table('parts', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->after('stock'); // Voeg prijs toe met twee decimalen
        });
    }

    public function down()
    {
        Schema::table('parts', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }

};
