<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreAssigned extends Model
{
    use HasFactory;
    protected $table = 'scoreAssigned';
    public $timestamps  = true;

    protected $fillable = [
        'value',
        'scoreId',
        'studentId',
    ];
}
