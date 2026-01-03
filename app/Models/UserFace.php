<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFace extends Model
{
    protected $table = 'user_face';

    protected $fillable = [
        'user_id',
        'file',
        'encode',
        'status',
        'c_by',
        'created_at',
        'updated_at',
    ];
}
