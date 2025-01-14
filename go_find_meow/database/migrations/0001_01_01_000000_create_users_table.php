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
            $table->id('user_id');
            $table->string('name', 30);
            $table->string('email', 35)->unique();
            $table->string('password');
            $table->string('phone_number', 20)->nullable();
            $table->string('profile_picture', 500)->nullable();
            $table->integer('role')-> default(2); //admin 0, mento 1, felhasznalo 2
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        User::create([
            'name'=> 'admin',
            'email'=> 'admin@admin.hu',
            'password'=> Hash::make('admin1234'),
            'phone_number'=> '12345677876',
            'profile_picture'=>'https://i0.wp.com/imagineab.se/wp-content/uploads/2017/11/human-icon.png?fit=750%2C750&ssl=1',
            'role'=> 0
        ]);

        User::create([
            'name'=> 'staff',
            'email'=> 'staff@staff.hu',
            'password'=> Hash::make('staff1234'),
            'phone_number'=> '12345677877',
            'profile_picture'=>'https://i0.wp.com/imagineab.se/wp-content/uploads/2017/11/human-icon.png?fit=750%2C750&ssl=1',
            'role'=> 1
        ]);

        User::create([
            'name'=> 'user',
            'email'=> 'user@user.hu',
            'password'=> Hash::make('user1234'),
            'phone_number'=> '12345677878',
            'profile_picture'=>'https://i0.wp.com/imagineab.se/wp-content/uploads/2017/11/human-icon.png?fit=750%2C750&ssl=1',
            'role'=> 2
        ]);

        
        User::create([
            'name'=> 'user2',
            'email'=> 'user2@user2.hu',
            'password'=> Hash::make('user21234'),
            'phone_number'=> '12345677879',
            'profile_picture'=>'https://i0.wp.com/imagineab.se/wp-content/uploads/2017/11/human-icon.png?fit=750%2C750&ssl=1',
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
