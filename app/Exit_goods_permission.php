<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exit_goods_permission extends Model
{
    protected $fillable = [
        'date_request_miladi',
        'date_request_shamsi',
        'enter_driver',
        'exit_driver',
        'jamdari_no',
        'request_timestamp',
        'jamdari_no',
        'date_enter_miladi',
        'date_exit_miladi',
        'date_exit_shamsi',
        'description',
        'exit_no',
        'enter_no',
        'car_no_exit',
        'car_no_enter',
        'car_name_exit',
        'car_name_enter',
        'id_goods_type',
        'id_herasat_enter',
        'id_herasat_exit',
        'id_requester',
        'id_request_part',
        'time_exit',
        'with_return',
        'time_request',
        'level',
        'time_enter',
        'date_enter_shamsi',
        'id_form',
        'enter_exit',
        'origin_destination',
        'reason1',
        'reason2',
        'reason3',
        'date_exit_shamsi_r',
        'date_enter_shamsi_r',
        'date_request_shamsi2',
        'iscomplete',
    ];




}
