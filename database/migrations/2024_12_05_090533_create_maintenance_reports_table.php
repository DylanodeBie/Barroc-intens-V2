<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('maintenance_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_id');
            $table->text('issue_description');
            $table->text('used_parts')->nullable();
            $table->text('follow_up_notes')->nullable();
            $table->timestamps();

            $table->foreign('visit_id')->references('id')->on('visits')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_reports');
    }
};
