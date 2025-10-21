<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{

    protected $fillable = [
        'name',
        'lyrics',
        'songwriter',
        'album_id'
    ];

    public $timestamps = false;

    function album()
    {
        return $this->belongsTo(Album::class);
    }
}
