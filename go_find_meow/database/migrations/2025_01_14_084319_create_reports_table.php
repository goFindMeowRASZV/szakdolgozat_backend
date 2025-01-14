<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
/* 
bejelentes_id
letrehozo_id
allapot
letrehozas_datum
ervenyesseg_vege
cim
szelessegi_fok
hosszusagi_fok
szin
minta
egyeb_ismertetojel
segitsegre_szorul
egeszsegugyi_allapot
kep
chipSzam
korulmenyek
peldanyok_szama
eltunes_datuma */
     
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id('report_id');
            $table->foreignId('creator_id')->references('user_id')->on('users');
            $table->string('status',1);//Talált, Keresett, Látott, Menhely
            $table->timestamps();
            $table->date('expiration_date');
            $table->string('address');
            $table->float('latitude'); //szelessegi_fok
            $table->float('longitude'); //hosszusagi_fok
            $table->string('color');
            $table->string('pattern');
            $table->string('other_identifying_marks',250)->nullable();
            $table->boolean('needs_help');
            $table->string('health_status', 250)->nullable();
            $table->string('photo',500)->nullable();
            $table->integer('chip_number')->nullable();
            $table->string('circumstances',250)->nullable();
            $table->integer('number_of_individuals')->nullable();
            $table->date('disappearance_date')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
