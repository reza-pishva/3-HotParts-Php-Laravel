<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupuser extends Model
{
    protected $fillable = [
        'id_user',
        'id_gr',
    ];
}
