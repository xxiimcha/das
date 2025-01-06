<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDormitoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dormitories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('name')->unique(); // Ensure unique dormitory names
            $table->string('location');
            $table->string('price_range');
            $table->integer('capacity');
            $table->text('description');
            $table->json('amenities')->nullable();
            $table->json('images')->nullable();
            $table->json('permits')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->softDeletes(); // Enable soft deletes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dormitories');
    }
}
