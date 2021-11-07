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
        'status',
        'instructorId',
    ];

    public function courseRecords()
    {
        return $this->hasMany(CourseRecord::class, "courseId");
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, "instructorId");
    }
}
