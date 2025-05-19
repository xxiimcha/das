<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('evaluation_criteria_ratings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('criteria_id');
            $table->unsignedTinyInteger('rating');
            $table->timestamps();

            $table->foreign('schedule_id')
                  ->references('id')
                  ->on('accreditation_schedules') // 🔁 Corrected from 'evaluation_schedules'
                  ->onDelete('cascade');

            $table->foreign('criteria_id')
                  ->references('id')
                  ->on('criteria')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_criteria_ratings');
    }
};
