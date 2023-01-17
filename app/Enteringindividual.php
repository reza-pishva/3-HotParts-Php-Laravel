<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enteringindividual extends Model
{
    protected $fillable = [
        'f_name',
        'l_name',
        'code_melli',
        'date_enter',
        'time_enter',
        'id_user',
        'enter_exit',
        'print',
        'DATE_TIMESTAMP',
        'DIFFERENCE',
    ];
}
