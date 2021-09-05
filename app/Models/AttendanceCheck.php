<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceCheck extends Model
{
    use HasFactory;
    protected $table = 'attendanceCheck';
    public $timestamps = true;

    protected $fillable = [
        'attendanceId',
        'studentId',
        'attendanceStatusId',
    ];
}
