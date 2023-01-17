<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ansaldo_savabegh extends Model
{
    protected $fillable = [
        'ID_E',
        'TIME_WORK',
        'DAMAGE_PERCENT',
        'ID_T',
        'TYPE_INSTAL',
        'DISCRIPTION',
        'SAV_TYPE',
        'ID_SUB',
    ];
}
