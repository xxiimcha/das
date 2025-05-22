<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyStatusColumnInCriteriaTable extends Migration
{
    public function up()
    {
        Schema::table('criteria', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('criteria', function (Blueprint $table) {
            $table->string('status')->change(); // or revert to the original type if known
        });
    }
}
