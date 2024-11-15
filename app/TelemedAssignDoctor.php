<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelemedAssignDoctor extends Model
{
    protected $table = 'telemed_assign_doctor';
    protected $guarded = array();

    public function doctor() {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    public function appointmentSchedule() //I add this
    {
        return $this->belongsTo(AppointmentSchedule::class, 'id');
    }
}