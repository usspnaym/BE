<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Malhal\Geographical\Geographical;

class Post extends Model
{
    use HasFactory, Geographical;
    const LATITUDE  = 'lat';
    const LONGITUDE = 'lng';
    protected $fillable = [
        'id',
        'user_id',
        'category_id',
        'name',
        'content',
        'lat',
        'lng'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }
}
