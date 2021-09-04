<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'course';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'campus',
        'career',
        'instructorId',
    ];

    public function courseRecords()
    {
        return $this->hasMany(CourseRecord::class, "courseId");
    }
}
