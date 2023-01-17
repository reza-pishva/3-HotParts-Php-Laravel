<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ansaldo_out_ghataat extends Model
{
    protected $fillable = [
        'ID_TG',
        'ID_USER',
        'DATE_BEGIN',
        'GROUP_COUNT',
        'DISCRIPTION',
        'LOCATION_NAME',
        'DATE_BEGIN',
        'OUT_IN',
        'ID_BA',
    ];
}
