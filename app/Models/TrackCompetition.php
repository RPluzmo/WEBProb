<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackCompetition extends Model
{
    protected $fillable = [
        'track_id',
        'title',
        'event_date',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function track()
    {
        return $this->belongsTo(Track::class);
    }
}

