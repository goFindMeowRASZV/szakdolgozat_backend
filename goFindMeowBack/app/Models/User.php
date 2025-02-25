<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'profile_picture',
        'role'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    //a ReportControllerben levő felhasznalok_bejelentesei fvhez
    public function reports()
    {
        return $this->hasMany(Report::class, 'creator_id');
    }

    // User.php model
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
