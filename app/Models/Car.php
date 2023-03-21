<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $appends = ['is_favorite'];
    
    protected $fillable = [
        'id',
        'owner_id', 'car_name',
        'price', 'fueltype',
        'cartype', 'description',
        'city_id','search_count',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
    
    public function getIsFavoriteAttribute()
    {
        if (auth('owner-api')->check()) {
            return $this->favoriters()->where('owner_id', auth('owner-api')->id())->exists();
        }
        return false;
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function favoriters()
    {
        return $this->hasMany(Favorite::class);
    }
}
