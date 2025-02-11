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
            $table->foreignId('creator_id')->references('id')->on('users')->default(0);
            $table->string('status', 1); //Talált, Keresett, Látott, Menhely
            $table->timestamps();
            $table->date('expiration_date')->nullable();
            $table->string('address', 100);
            /*   $table->float('latitude')->nullable();; //szelessegi_fok
            $table->float('longitude')->nullable();; //hosszusagi_fok */
            $table->json('color');
            $table->json('pattern');
            $table->string('other_identifying_marks', 250)->nullable();
            /* $table->boolean('needs_help')->nullable(); */
            $table->string('health_status', 250)->nullable();
            $table->string('photo', 2048)->nullable();
            $table->bigInteger('chip_number')->nullable();
            $table->string('circumstances', 250)->nullable();
            $table->integer('number_of_individuals')->nullable()->default(1);
            $table->date('disappearance_date')->nullable();
        });



        Report::create([
            'creator_id' =>  3,
            'status' => 'L', //látott
            /* 'expiration_date' => '20250628', */
            'address' => '1147, Budapest, Baross utca 2',
            /*  'latitude'=> 47.455029,
            'longitude' =>  19.230738, */
            'color' => 'vörös, fehér',
            'pattern' => 'cirmos',
            'other_identifying_marks' => 'hosszú szőrű',
            /*  'needs_help'=> false, */
            'health_status' => null,
            'photo' => '\public\uploads\1738674438.jpg',
            'chip_number' => null,
            'circumstances' => 'félős',
            'number_of_individuals' => 1,
            'disappearance_date' => null

        ]);

        Report::create([
            'creator_id' =>  3,
            'status' => 'L', //látott
          /*   'expiration_date' => '20250628', */
            'address' => 'Pécel, Maglódi út, 2119',
            /* 'latitude'=> 47.463074,
            'longitude' =>  19.346008, */
            'color' => 'szürke, fehér',
            'pattern' => 'foltos',
            'other_identifying_marks' => 'hosszú szőrű',
            /* 'needs_help'=> false, */
            'health_status' => null,
            'photo' => '\public\uploads\caca5.jpg',
            'chip_number' => null,
            'circumstances' => 'játékos, bátor',
            'number_of_individuals' => 1,
            'disappearance_date' => null

        ]);

        Report::create([
            'creator_id' =>  3,
            'status' => 'L', //látott
            /* 'expiration_date' => '20250628', */
            'address' => 'Budapest, Rigó u. 6, 1085',
            /* 'latitude'=> 47.490510, 
            'longitude' =>  19.072686, */
            'color' => 'fekete, fehér',
            'pattern' => 'cirmos',
            'other_identifying_marks' => 'pár hónapos lehet',
            /*  'needs_help'=> false, */
            'health_status' => null,
            'photo' => '\public\uploads\cica1.jpg',
            'chip_number' => null,
            'circumstances' => null,
            'number_of_individuals' => 1,
            'disappearance_date' => null

        ]);

        Report::create([
            'creator_id' =>  3,
            'status' => 'L', //látott
            /* 'expiration_date' => '20250628', */
            'address' => 'Budapest, Rákóczi út 15, 1088',
            /* 'latitude' => 47.495076,
            'longitude' =>  19.063371, */
            'color' => 'vörös, fehér',
            'pattern' => 'cirmos',
            'other_identifying_marks' => 'jó vadász',
            /* 'needs_help'=> false, */
            'health_status' => null,
            'photo' => '\public\uploads\cica2.jpg',
            'chip_number' => null,
            'circumstances' => null,
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
