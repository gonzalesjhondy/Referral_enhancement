<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'code',
        'sender',
        'receiver',
        'message'
    ];
}
