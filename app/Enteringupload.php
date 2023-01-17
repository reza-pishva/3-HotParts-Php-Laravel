<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enteringupload extends Model
{
    protected $fillable = [
        'id_ef',
        'id_user',
        'description',
    ];
}
