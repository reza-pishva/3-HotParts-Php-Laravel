<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mitsubishi_resv_bazsazi_ghataat extends Model
{
    protected $fillable = [
        'ID_T',
        'COUNT_TAGH',
        'ID_USER',
        'COUNT_GH',
        'RESV',
        'DATE_SHAMSI',
        'FILE_NAME',
    ];
}
