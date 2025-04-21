<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_number', 20)->nullable();
            $table->string('profile_picture', 500)->nullable();
            $table->integer('role')-> default(2); //admin 0, mento 1, felhasznalo 2
            $table->rememberToken();
            $table->timestamps();
        });

        
        User::create([
            'name'=> 'admin',
            'email'=> 'admin@admin.hu',
            'password'=> Hash::make('admin1234'),
            'phone_number'=> '12345677876',
            'profile_picture'=>'/kepek/user.jpg',
            'role'=> 0
        ]);

        User::create([
            'name'=> 'staff',
            'email'=> 'staff@staff.hu',
            'password'=> Hash::make('staff1234'),
            'phone_number'=> '12345677877',
            'profile_picture'=>'/kepek/user.jpg',
            'role'=> 1
        ]);

        User::create([
            'name'=> 'user',
            'email'=> 'user@user.hu',
            'password'=> Hash::make('user1234'),
            'phone_number'=> '12345677878',
            'profile_picture'=>'/kepek/user.jpg',
            'role'=> 2
        ]);

        
        User::create([
            'name'=> 'user2',
            'email'=> 'user2@user2.hu',
            'password'=> Hash::make('user21234'),
            'phone_number'=> '12345677879',
            'profile_picture'=>'/kepek/user.jpg',
            'role'=> 2
        ]);
        User::create([
            'name'=> 'user3',
            'email'=> 'user3@user3.hu',
            'password'=> Hash::make('user31234'),
            'phone_number'=> '12345677879',
            'profile_picture'=>'/kepek/user.jpg',
            'role'=> 2
        ]);
 
 
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
