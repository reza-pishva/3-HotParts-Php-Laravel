<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'enter_exit',
        'id_requester',
        'date_shamsi',
        'date_miladi',
        'timestamp',
    ];
}
