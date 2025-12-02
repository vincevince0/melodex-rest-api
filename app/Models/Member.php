<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    Use HasFactory;
    protected $fillable = [
        'name',
        'instrument',
        'year',
        'artist_id',
        'image'
    ];
    
    public $timestamps = false;

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id');
    }
}
