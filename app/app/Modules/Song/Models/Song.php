<?php

namespace App\Modules\Song\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    public $timestamps = false;
    protected $table = 'songs';
    protected $fillable = [
        'id', 'song_name'
    ];
}
