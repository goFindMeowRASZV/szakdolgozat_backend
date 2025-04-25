<?php

use App\Models\Report;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id('report_id');
            $table->foreignId('creator_id')->references('id')->on('users')->default(0);
            $table->string('status', 1); //Talált, Keresett, Látott, Menhely
            $table->timestamps();
            $table->string('address', 255);
            $table->float('lat')->nullable(); //szelessegi_fok
            $table->float('lon')->nullable(); //hosszusagi_fok */
            $table->string('color');
            $table->string('pattern');
            $table->string('other_identifying_marks', 250)->nullable();
            $table->string('health_status', 250)->nullable();
            $table->string('photo', 2048)->nullable();
            $table->bigInteger('chip_number')->nullable();
            $table->string('circumstances', 250)->nullable();
            $table->integer('number_of_individuals')->nullable()->default(1);
            $table->date('disappearance_date')->nullable();
            $table->integer('activity')->default(1);// 1 aktiv, 0 nem aktiv
        });



        Report::create([
            'creator_id' =>  3,
            'status' => 'm', 
            'address' => '1147, Budapest, Baross utca 2',
            'lat'=> 47.455029,
            'lon' =>  19.230738,
            'color' => 'vörös',
            'pattern' => 'cirmos',
            'other_identifying_marks' => 'hosszú szőrű',
            'health_status' => null,
            'photo' => 'http://localhost:8000/uploads/1738674438.jpg',
            'chip_number' => null,
            'circumstances' => 'félős',
            'number_of_individuals' => 1,
            'disappearance_date' => null
            
        ]);

        Report::create([
            'creator_id' =>  3,
            'status' => 'm', 
            'address' => 'Pécel, Maglódi út, 2119',
            'lat'=> 47.463074,
            'lon' =>  19.346008,
            'color' => 'szürke, fehér',
            'pattern' => 'foltos',
            'other_identifying_marks' => 'hosszú szőrű',
            'health_status' => null,
            'photo' => 'http://localhost:8000/uploads/caca5.jpg',
            'chip_number' => null,
            'circumstances' => 'játékos, bátor',
            'number_of_individuals' => 1,
            'disappearance_date' => null

        ]);

        Report::create([
            'creator_id' =>  3,
            'status' => 'l', //látott
            'address' => 'Budapest, Rigó u. 6, 1085',
            'lat'=> 47.490510, 
            'lon' =>  19.072686,
            'color' => 'fekete, fehér',
            'pattern' => 'cirmos',
            'other_identifying_marks' => 'pár hónapos lehet',
            'health_status' => null,
            'photo' => 'http://localhost:8000/uploads/cica1.jpg',
            'chip_number' => null,
            'circumstances' => null,
            'number_of_individuals' => 1,
            'disappearance_date' => null

        ]);

        Report::create([
            'creator_id' =>  3,
            'status' => 'k', 
            'address' => 'Budapest, Rákóczi út 15, 1088',
            'lat' => 47.495076,
            'lon' =>  19.063371,
            'color' => 'vörös, fehér',
            'pattern' => 'cirmos',
            'other_identifying_marks' => 'jó vadász',
            'health_status' => null,
            'photo' => 'http://localhost:8000/uploads/cica2.jpg',
            'chip_number' => null,
            'circumstances' => null,
            'number_of_individuals' => 1,
            'disappearance_date' => null

        ]);
    }

    
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
