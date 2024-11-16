<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = "posts";
    protected $fillable = [
       'user_id',
       'content',
    ];
    public function images(){
        return $this->hasMany(PostImage::class,'post_id','id');
    }
    public function comments(){
        return $this->hasMany(Comment::class,'post_id','id');
    }
}
