<?php

namespace App\Http\Controllers\doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AcceptedCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('doctor');
    }


}
