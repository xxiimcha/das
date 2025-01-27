<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToAccreditationSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accreditation_schedules', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('evaluation_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accreditation_schedules', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
