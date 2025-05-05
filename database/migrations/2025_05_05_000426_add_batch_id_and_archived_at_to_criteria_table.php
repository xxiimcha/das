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
        Schema::table('criteria', function (Blueprint $table) {
            $table->string('batch_id')->nullable()->after('id');
            $table->timestamp('archived_at')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('criteria', function (Blueprint $table) {
            $table->dropColumn(['batch_id', 'archived_at']);
        });
    }

};
