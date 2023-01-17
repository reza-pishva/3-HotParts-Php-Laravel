<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workflow2 extends Model
{
    protected $fillable = [
        'level',
        'id_ef',
        'id_user',
        'date_shamsi',
        'description',
    ];



}
