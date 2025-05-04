<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriteriaColumnsTable extends Migration
{
    public function up(): void
    {
        Schema::create('criteria_columns', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Column label
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('criteria_columns');
    }
}
