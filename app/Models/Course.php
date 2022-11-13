<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Episode;
use App\Models\Cart;
use App\Models\User;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'thumbnail',
        'description',
        'price',
        'user_id'
    ];

    public function episodes(){
        return $this->hasMany(Episode::class);
    }

    public function carts(){
        return $this->belongsToMany(Cart::class);
    }

    public function users(){
        $this->belongsToMany(User::class);
    }
}
