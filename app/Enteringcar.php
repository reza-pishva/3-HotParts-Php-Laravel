<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enteringcar extends Model
{
    protected $fillable = [
        'id_ef',
        'id_user',
        'car_name',
        'car_no',
        'driver_name',
        'area',
        'date_shamsi_exit',
    ];
}
