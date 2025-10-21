<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = [
        'name',
        'cover',
        'year',
        'genre',
        'artist_id'
    ];
    public $timestamps = false;

    function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    function song()
    {
        return $this->hasMany(Song::class);
    }

}
