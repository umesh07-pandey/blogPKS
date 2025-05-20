<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Profile;

class Registration extends Authenticatable implements JWTSubject

{
    use HasFactory;
    protected $table="registration";
    protected $fillable=[
        'name',
        'email',
        'password',
        'role',
        
    ];


      public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'id'=>$this->id,
            'email'=>$this->email,
            'role'=>$this->role
        ];
    }

    public function profile(){
        return $this->hasOne(Profile::class,'registration_id');
    }

}
