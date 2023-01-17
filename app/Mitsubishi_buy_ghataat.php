<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mitsubishi_buy_ghataat extends Model
{
    protected $fillable = [
        'ID_TG',
        'ID_SE',
        'ID_USER',
        'SHOMAREH_GHARAR',
        'DATE_SHAMSI',
        'GROUP_COUNT',
        'DISCRIPTION',
        'RESV',
        'BUY_CONDITION',
    ];
}
