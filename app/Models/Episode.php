<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'video',
        'course_id',
        'user_id',
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
