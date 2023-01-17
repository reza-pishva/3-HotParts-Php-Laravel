<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Querytext extends Model
{
    protected $fillable = [
        'query_text',
        'id_user',
    ];
}
