<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'track_id',
        'slot',
        'path'
    ];

    public function track()
    {
        return $this->belongsTo(Track::class);
    }
}
