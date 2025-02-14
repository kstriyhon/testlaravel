<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TVSchedule extends Model
{
    use HasFactory;

    protected $table = 'tv_schedules'; // Explicitly define the correct table name
    protected $fillable = ['date', 'time', 'title', 'description'];
}

