<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mitsubishi_store_program_out extends Model
{
    protected $fillable = [
        'ID_T',
        'COUNT_TAGH',
        'ID_USER',
        'COUNT_GH',
        'RESV',
        'DATE_SHAMSI2',
    ];
}
