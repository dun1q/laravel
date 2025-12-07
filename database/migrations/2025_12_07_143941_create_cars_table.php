<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('year');
            $table->decimal('price', 10, 2);
            $table->integer('mileage_km');
            $table->string('image_path');
            $table->timestamps();
            $table->softDeletes(); // для Soft Deletes
        });
    }

    public function down()
    {
        Schema::dropIfExists('cars');
    }
};