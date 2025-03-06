<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('evaluations')) {
            Schema::create('evaluations', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('schedule_id')->unsigned();
                $table->string('evaluator_name');
                $table->dateTime('evaluation_date');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
}
