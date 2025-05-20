<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Profile extends Model
{
    use HasFactory;
    protected $table="profile";
    protected $fillable = [
        "gender",
        "dob",
        "profilepic",
        "registration_id",
        "category_id"
        
    ];

    public function user(){
        return $this->belongsTo(Registration::class);
    }

    public function preferredCategories() {
    return $this->belongsToMany(Category::class, 'preferred_categories');
}

    


}
