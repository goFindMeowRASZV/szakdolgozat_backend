<?php

use App\Models\ShelteredCat;
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
        Schema::create('sheltered_cats', function (Blueprint $table) {
            $table->id('cat_id');
            $table->foreignId('rescuer')->references('id')->on('users');
            $table->foreignId('report')->references('report_id')->on('reports');
            $table->foreignId('owner')->nullable()->references('id')->on('users');
            $table->timestamps();
            $table->date('adoption_date')->nullable();
            $table->integer('kennel_number');
            $table->string('medical_record',200);
            $table->string('status',1);//aktiv, örökbeadott, elhunyt
            $table->bigInteger('chip_number')->nullable();
            $table->string('breed');
         /*    $table->string('photo',500); */
        });

        
        ShelteredCat::create([
            'rescuer'=> 2,
            'report' => 1,
            'owner' => null,
            'adoption_date' => null,
            'kennel_number' => 100,
            'medical_record' => 'napi 2x etetni, + napi 1x Neoxide fülcsepp',
            'status' => 'A',
            'chip_number' => 123456789112345,
            'breed' => 'házi macska'
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sheltered_cats');
    }
};
