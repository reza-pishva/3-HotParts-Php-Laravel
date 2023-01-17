<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Smslist extends Model
{
    protected $fillable = [
        'date_shamsi_sms', 'time_sms', 'description','id_user','mobile',
    ];
}
