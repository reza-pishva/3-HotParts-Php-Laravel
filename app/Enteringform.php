<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enteringform extends Model
{
    protected $fillable = [
        'id_ef',
        'title',
        'company',
        'date_shamsi',
        'permission1',
        'permission2',
        'permission3',
        'reason1',
        'reason2',
        'reason3',
        's1',
        's2',
        's3',
        's4',
        's5',
        'id_user',
        'level',
        'id_request_part',
    ];
}
