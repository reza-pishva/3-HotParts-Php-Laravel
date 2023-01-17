<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enteringeq extends Model
{
    protected $fillable = [
        'id_ef',
        'id_user',
        'description',
    ];
}
