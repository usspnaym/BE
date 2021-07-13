<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'category_id',
        'name',
        'content'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function categorys(){
        return $this->belongsToMany(Category::class);
    }
}
