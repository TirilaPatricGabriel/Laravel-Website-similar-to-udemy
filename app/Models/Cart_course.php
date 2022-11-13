<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart_course extends Model
{
    use HasFactory;

    protected $table = "cart_course";

    protected $fillable = [
        'cart_id',
        'course_id'
    ];
}
