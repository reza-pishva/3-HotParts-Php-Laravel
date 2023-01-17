<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enteringpeaple extends Model
{
    protected $fillable = [
        'id_ef',
        'id_et',
        'f_name',
        'l_name',
        'code_melli',
        'mobile',
        'time_enter',
        'date_shamsi_enter',
        'time_exit',
        'date_shamsi_exit',
        'nationality',
        'age',
        'cond1',
        'cond2',
        'cond3',
        'cond4',
        'cond5',
        'cond6',
        'cardno',
        'let_show',
    ];
}
