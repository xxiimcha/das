<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommitteeIdToDormitoriesTable extends Migration
{
    public function up()
    {
        Schema::table('dormitories', function (Blueprint $table) {
            $table->unsignedBigInteger('committee_id')->nullable()->after('user_id');
            $table->foreign('committee_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('dormitories', function (Blueprint $table) {
            $table->dropForeign(['committee_id']);
            $table->dropColumn('committee_id');
        });
    }
}
