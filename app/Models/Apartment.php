<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'n_rooms',
        'n_bathrooms',
        'n_beds',
        'square_meters',
        'address',
        'visibility',
        'img_cover',
        'description',
        'longitude',
        'latitude',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function visuals()
    {
        return $this->hasMany(Visual::class);
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
