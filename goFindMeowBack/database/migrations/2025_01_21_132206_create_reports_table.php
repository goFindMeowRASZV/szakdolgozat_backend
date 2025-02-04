<?php

use App\Models\Report;
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
        Schema::create('reports', function (Blueprint $table) {
            $table->id('report_id');
            $table->foreignId('creator_id')->references('id')->on('users');
            $table->string('status',1);//Talált, Keresett, Látott, Menhely
            $table->timestamps();
            $table->date('expiration_date');
            $table->string('address',100);
            $table->float('latitude'); //szelessegi_fok
            $table->float('longitude'); //hosszusagi_fok
            $table->json('color');
            $table->json('pattern');
            $table->string('other_identifying_marks',250)->nullable();
            $table->boolean('needs_help');
            $table->string('health_status', 250)->nullable();
            $table->string('photo',2048)->nullable();
            $table->bigInteger('chip_number')->nullable();
            $table->string('circumstances',250)->nullable();
            $table->integer('number_of_individuals')->nullable()-> default(1);
            $table->date('disappearance_date')->nullable();

        });

        
        Report::create([
            'creator_id'=>  3,
            'status' => 'L', //látott
            'expiration_date' => '20250628',
            'address' => '1068, Budapest, Király utca 96',
            'latitude'=> 47.505770,
            'longitude' => 19.069553,
            'color' => 'fekete, fehér',
            'pattern' => 'foltos',
            'other_identifying_marks' => 'le van vágva a jobb fülének a sarka',
            'needs_help'=> false,
            'health_status' => null,
            'photo' => 'https://cdn12.picryl.com/photo/2016/12/31/cat-stray-kitty-animals-271146-1024.jpg',
            'chip_number' => null,
            'circumstances' => 'félős nagyon',
            'number_of_individuals' => 1,
            'disappearance_date' => null
            
        ]); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
