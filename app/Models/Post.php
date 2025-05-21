<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

   public function oneUser(){
        return $this->belongsTo(Registration::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
