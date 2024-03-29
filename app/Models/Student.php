<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Student extends Model
{
    use HasFactory;
    protected $table = "student";
    public $timestamps = true;

    protected $fillable = [
        'firstname',
        'lastname',
        'studentCode',
        'courseRecordId'
    ];

    public function scoresAssigned()
    {
        return $this->hasMany(ScoreAssigned::class, 'studentId');
    }

    public function attendancesCheck()
    {
        return $this->hasMany(AttendanceCheck::class, 'studentId');
    }
}
