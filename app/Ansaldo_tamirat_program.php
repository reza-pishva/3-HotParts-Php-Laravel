<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ansaldo_tamirat_program extends Model
{
    protected $fillable = [
        'ID_UN',
        'ID_USER',
        'ID_NN',
        'ID_TT',
        'ID_TA',
        'TIME_WORK_REAL',
        'TIME_WORK_EQUAL',
        'DATE_BEGIN',
        'DATE_END',
        'DISCRIPTION',
        'DATE_BEGIN_FORCAST',
        'DURATION',
        'ANGAM',
        'FILE_NA',
        'CONFIR',
        'PATTERN_CODE',
        'ENG_VIEW',
        'DATE_BEGIN_SH',
        'DATE_END_SH',
        'FILE_NAME',
    ];
}
