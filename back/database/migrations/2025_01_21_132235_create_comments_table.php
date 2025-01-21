<?php

use App\Models\Comment;
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
        Schema::create('comments', function (Blueprint $table) {
            $table->foreignId('report')->references('report_id')->on('reports');
            $table->foreignId('user')->references('id')->on('users');
            $table->timestamps();
            $table->string('content',250);
            $table->string('photo',500)->nullable();
        });

        Comment::create([
            'report' => 1,
            'user' => 4,
            'content' => 'A környéken láttam egy ehhez hasonló macskát, lehet, hogy ő az?',
            'photo' => 'https://t4.ftcdn.net/jpg/07/94/18/55/360_F_794185583_OrEtKCqtXvdDDiJL0TUySbAZnk9ee2If.jpg'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
