<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabRequest extends Model
{
    protected $table = 'lab_request';
    protected $guarded = array();

    public function requestedBy() {
        return $this->belongsTo(User::class, 'requested_by', 'id');
    }
}
