<?php

namespace App\Models;

use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
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
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function comments(){
        return $this->hasMany(Comment::class,'post_id','id');
    }
    public function likes(){
        return $this->hasMany(Like::class,'post_id','id');
    }
}
