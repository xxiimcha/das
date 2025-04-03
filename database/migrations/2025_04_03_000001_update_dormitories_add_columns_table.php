<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDormitoriesAddColumnsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dormitories', function (Blueprint $table) {
            $table->text('formatted_address')->nullable()->after('location');
            $table->string('contact_number')->nullable()->after('formatted_address');
            $table->string('email')->nullable()->after('contact_number');
            $table->text('owner_address')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dormitories', function (Blueprint $table) {
            $table->dropColumn([
                'formatted_address',
                'contact_number',
                'email',
                'owner_address'
            ]);
        });
    }
}
