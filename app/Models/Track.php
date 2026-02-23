<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'lat',
        'lng',
        'description',
        'surface_type',
        'competitions',
        'owner_id',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function riders()
    {
        return $this->hasMany(Rider::class);
    }

    public function events()
    {
        return $this->hasMany(TrackCompetition::class)->orderBy('event_date');
    }
}
