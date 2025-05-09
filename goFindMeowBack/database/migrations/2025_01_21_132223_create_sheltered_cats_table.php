<?php

use App\Models\ShelteredCat;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sheltered_cats', function (Blueprint $table) {
            $table->id('cat_id');
            $table->foreignId('rescuer')->references('id')->on('users');
            $table->foreignId('report')->references('report_id')->on('reports');
            $table->foreignId('owner')->nullable()->references('id')->on('users');
            $table->timestamps();
            $table->date('adoption_date')->nullable();
            $table->integer('kennel_number')->nullable();
            $table->string('medical_record',200)->nullable();
            $table->string('s_status',1)->default("a");//aktiv, örökbeadott, elhunyt
            $table->bigInteger('chip_number')->nullable();
            $table->string('breed')->nullable();
        });

        
       

    }


    public function down(): void
    {
        Schema::dropIfExists('sheltered_cats');
    }
};
