<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enteringhistory extends Model
{
    protected $fillable = [
        'id_ef',
        'level',
        'description',
    ];
}
