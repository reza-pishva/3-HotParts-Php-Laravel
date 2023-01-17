<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request_level extends Model
{
    protected $fillable = [
        'id_exit',
        'level',
    ];
}
