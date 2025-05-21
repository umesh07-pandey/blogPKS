<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';

    protected $fillable = [
        "category",
    ];
    public function user()
    {
        return $this->belongsTo(Registration::class);
    }


    public function profileaccess()
    {
        return $this->belongsToMany(Profile::class, 'preferred_categories');
    }
    
    
    public function post()
    {
        return $this->hasMany(Post::class);
    }

}
