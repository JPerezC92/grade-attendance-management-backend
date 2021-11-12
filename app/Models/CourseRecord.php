<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CourseRecord extends Model
{
    use HasFactory;

    protected $table = "courseRecord";
    public $timestamps = true;

    protected $fillable = [
        'name',
        'career',
        'turn',
        'group',
        'semester',
        'instructorId',
        'courseId',
        'periodId',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'courseRecordId');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'courseRecordId');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'courseRecordId')->orderBy('attendance.date');
    }

    public function period()
    {
        return $this->belongsTo(Period::class, 'periodId');
    }
}
