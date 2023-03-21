<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Owner extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'city_id',
        'password',
    ];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function favoriters()
    {
        return $this->hasMany(Favorite::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
