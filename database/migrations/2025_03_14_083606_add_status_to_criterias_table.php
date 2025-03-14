<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('criterias', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('active')->after('values');
        });
    }

    public function down()
    {
        Schema::table('criterias', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
