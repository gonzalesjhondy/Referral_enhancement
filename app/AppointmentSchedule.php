<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentSchedule extends Model
{
    protected $table = 'appointment_schedule';
    protected $guarded = array();

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function facility() {
        return $this->belongsTo(Facility::class, 'facility_id', 'id');
    }

    public function department() {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    
    public function telemedAssignedDoctor() {
        return $this->hasMany(TelemedAssignDoctor::class, 'appointment_id', 'id');
    }

    // public function telemedDoctor() {
    //     return $this->hasOne(TelemedAssignedDoctor::class, 'appointment_id');
    // }

   
}
