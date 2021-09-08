<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $table = "instructor";
    public $timestamps = true;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'status'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, "instructorId");
    }

    public function periods()
    {
        return $this->hasMany(Period::class, "instructorId");
    }
}
