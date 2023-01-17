<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enteringin extends Model
{
    protected $fillable = [
        'id_ef',
        'id_user',
        'description',
        'serial_no',
    ];
}
