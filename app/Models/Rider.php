<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    protected $fillable = [
        'track_id',
        'user_id',
        'name',
        'club',
        'club_id',
        'category',
        'experience_level',
        'ride_date',
        'ride_time',
    ];

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    public function clubRelation()
    {
        return $this->belongsTo(Club::class, 'club_id');
    }
}
