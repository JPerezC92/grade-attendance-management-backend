<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activity';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'courseRecordId',
    ];

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
