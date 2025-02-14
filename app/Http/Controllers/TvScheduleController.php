<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TvScheduleController extends Controller
{
    public function index()
    {
        return view('tv_schedule.index');
    }
}
