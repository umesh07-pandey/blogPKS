<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory;
    protected $table="post";
    protected $fillable = [
        "title",
        "description",
        "registration_id",
        "category_id"
    ];
    // public $comment=[

    // ];


   public function oneUser(){
        return $this->belongsTo(Registration::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
