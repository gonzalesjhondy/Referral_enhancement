<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activity';
    protected $guarded = array();

    public function patient() {
        return $this->belongsTo(Patients::class, 'patient_id', 'id');
    }

    public function referredTo() {
        return $this->belongsTo(Facility::class, 'referred_to', 'id');
    }

    public function labRequest() {
        return $this->hasMany(labRequest::class, 'activity_id', 'id');
    }
}
