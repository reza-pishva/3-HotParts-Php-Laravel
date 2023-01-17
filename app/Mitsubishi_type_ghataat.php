<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mitsubishi_type_ghataat extends Model
{
    protected $fillable = [
        'GHATAAT_NAME',
        'TIME_STANDARD',
        'TYPE_CODE',
        'SET_COUNT',
        'COUNTB_REJECT',
        'TIME_REJECT',
        'ID_USER',
    ];
}
