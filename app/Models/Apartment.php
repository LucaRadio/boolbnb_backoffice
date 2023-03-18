<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use HasFactory, SoftDeletes;

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
        'user_id',
        'deleted_at'
    ];

    protected $hidden = [
        'id',
        'visibility',
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id',
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
        return $this->belongsToMany(Promotion::class)->withPivot(['created_at', 'updated_at', 'expired_at']);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
