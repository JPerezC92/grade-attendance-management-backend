<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table = "attendance";
    public $timestamps = true;

    protected $fillable = [
        'date',
        'type',
        'courseRecordId',
    ];

    public function attendanceChecks()
    {
        return $this->hasMany(AttendanceCheck::class, 'attendanceId');
    }
}
