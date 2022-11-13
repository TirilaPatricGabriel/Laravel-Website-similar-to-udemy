<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course_user extends Model
{
    use HasFactory;

    protected $table = 'course_user';

    protected $fillable = [
        'user_id',
        'course_id'
    ];
}