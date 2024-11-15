<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baby extends Model
{
    protected $table = 'baby';
    protected $fillable = [
        'baby_id',
        'mother_id',
        'weight',
        'gestational_age'
    ];
}
