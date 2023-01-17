<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    protected $fillable = [
        'date_shamsi',
        'date_time',
        'id_exit',
        'id_requester',
        'id_request_part',
        'level',
        'time_stamp',
    ];



}
