<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_file extends Model
{
    protected $table = 'm_file';

    protected $fillable = [
        'f_id',
        'cat',
        'file',
        'status',
        'c_by',
        'created_at',
        'updated_at',
    ];
}
