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
        'instructorId',
        'courseId',
        'periodId',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
