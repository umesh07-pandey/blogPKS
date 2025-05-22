<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = "comment";
    protected $fillable = [
        "comment",
        "post_id",
        "registration_id"
    ];
    protected $object = [
        "comment",
        "registration_id"
    ];

    public function postcomment()
    {
        return $this->belongsTo(Post::class);
    }
    public function userData()
    {
        return $this->belongsTo(Registration::class);
    }
}

