<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeDormitoryFieldsNullable extends Migration
{
    public function up()
    {
        Schema::table('dormitories', function (Blueprint $table) {
            $table->string('formatted_address')->nullable()->change();
            $table->string('contact_number')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('owner_address')->nullable()->change();
            $table->string('price_range')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->string('invitation_token')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('dormitories', function (Blueprint $table) {
            $table->string('formatted_address')->nullable(false)->change();
            $table->string('contact_number')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('owner_address')->nullable(false)->change();
            $table->string('price_range')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
            $table->string('invitation_token')->nullable(false)->change();
        });
    }
}
