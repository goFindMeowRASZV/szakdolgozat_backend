<?php

use App\Models\Comment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->foreignId('report')->references('report_id')->on('reports');
            $table->foreignId('user')->references('id')->on('users');
            $table->timestamps();
            $table->string('content', 250);
            $table->string('photo', 500)->nullable();
        });

        // Report 
        Comment::create([
            'report' => 1,
            'user' => 6,
            'content' => 'A környéken láttam egy hasonló cicát, lehet, hogy ő az?'
           
        ]);
        Comment::create([
            'report' => 1,
            'user' => 7,
            'content' => 'Nagyon hasonlít a szomszéd macskájára, de nem vagyok biztos benne.'

        ]);
        Comment::create([
            'report' => 1,
            'user' => 8,
            'content' => 'Láttam a játszótér mellett egy cicát, ami így nézett ki!',
            'photo' => '/kepek/commentKep2.jpg'
        ]);

        // Report 
        Comment::create([
            'report' => 2,
            'user' => 6,
            'content' => 'Szerintem ezt a macskát már korábban is keresték.',
            'photo' => '/kepek/commentKep.jpg'
        ]);
        Comment::create([
            'report' => 2,
            'user' => 7,
            'content' => 'Én a bolt mögött láttam egy ilyet.',
        ]);
        Comment::create([
            'report' => 2,
            'user' => 8,
            'content' => 'Nagyon aranyos cica, remélem hamar hazakerül!',
        ]);
        Comment::create([
            'report' => 2,
            'user' => 7,
            'content' => 'A buszmegállónál is feltűnt egy ilyen színű macska.',
        ]);

        // Report 
        Comment::create([
            'report' => 5,
            'user' => 8,
            'content' => 'Tegnap este láttam hasonlót az utcán.',
        ]);
        Comment::create([
            'report' => 5,
            'user' => 6,
            'content' => 'Szerintem ő lehet az, bár nehéz volt megfigyelni.',
        ]);
        Comment::create([
            'report' => 5,
            'user' => 7,
            'content' => 'Nagyon ismerős a mintázata!'
        ]);

        // Report 
        Comment::create([
            'report' => 6,
            'user' => 6,
            'content' => 'Sajnos nem tudtam megközelíteni, de hasonlított rá.',
            'photo' => '/kepek/commentKep3.jpg'
        ]);
        Comment::create([
            'report' => 6,
            'user' => 7,
            'content' => 'De drága!'
        ]);
        Comment::create([
            'report' => 6,
            'user' => 8,
            'content' => 'A parkolónál bóklászott egy ilyen macska.'
        ]);

        // Menhely 
        Comment::create([
            'report' => 4,
            'user' => 7,
            'content' => 'Lehet, hogy ismerem a gazdáját, meghívom ide!'
        ]);
        Comment::create([
            'report' => 4,
            'user' => 8,
            'content' => 'Sziasztok ő az én cicám, írtam nektek e-mailt.'
        ]);
        Comment::create([
            'report' => 4,
            'user' => 6,
            'content' => 'Az állatorvosnál hallottam róla.'
        ]);
     

        // Menhely
        Comment::create([
            'report' => 3,
            'user' => 6,
            'content' => '😍😍😍'
        ]);
        Comment::create([
            'report' => 3,
            'user' => 8,
            'content' => 'Volt régen egy ilyen cicám :(.'
        ]);

        //Menhely
        Comment::create([
            'report' => 10,
            'user' => 7,
            'content' => 'Már régóta szeretnék egy ilyen cicát!.'
        ]);
    }


    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
