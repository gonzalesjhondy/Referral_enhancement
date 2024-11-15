<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devicetoken extends Model
{
    protected $table = 'devicetoken';
    protected $fillable = ['facility_id','token'];
}
