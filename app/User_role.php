<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_role extends Model
{
    protected $fillable = [
        'id_role', 'id_user',
    ];
}
