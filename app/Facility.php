<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $table = 'facility';
    protected $guarded = array();



    //------------------------------------------------
    public function opdFacilities()
    {
        return $this->belongsTo(User::class, 'id', 'facility_id');
    }
    //------------------------------------------------

    //------------------------------I add this -------//
    public function appointmentSchedules()
    {
        return $this->hasMany(AppointmentSchedule::class, 'facility_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'referred_to');
    }

}


