<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $guarded = array();

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'referring_md');
    }
}
