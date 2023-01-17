<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mitsubishi_unit_number extends Model
{
    protected $fillable = [
        'ID_NN',
        'ID_USER',
        'UNIT_NUMBER',
        'unitNumberDigit',
    ];
}
