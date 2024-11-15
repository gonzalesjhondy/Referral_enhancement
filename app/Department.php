<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'department';





    //------------------------------------------------
    public function opdDepartment()
    {
        return $this->belongsTo(User::class, 'id', 'department_id');
    }
    //------------------------------------------------


}
