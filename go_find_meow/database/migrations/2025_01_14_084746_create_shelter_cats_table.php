<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shelter_cats', function (Blueprint $table) {
            $table->id('cat_id');
            $table->foreignId('rescuer')->references('user_id')->on('users');
            $table->foreignId('report')->references('report_id')->on('reports');
            $table->foreignId('owner')->references('user_id')->on('users')->nullable();
            $table->timestamps();
            $table->date('adoption_date')->nullable();
            $table->integer('kennel_number');
            $table->string('medical_record',200);
            $table->string('status');//aktiv, örökbeadott, elhunyt
            $table->integer('chip_number')->nullable();
            $table->string('breed');
            $table->string('photo',500);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shelter_cats');
    }
};
