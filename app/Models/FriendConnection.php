<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendConnection extends Model
{
    use HasFactory;
    protected $table = "friend_connections";
    protected $fillable = [
        'user_id',
        'friend_id',
        
     ];
     public function user()
     {
         return $this->belongsTo(User::class, 'user_id');
     }
     public function friend()
     {
         return $this->belongsTo(User::class, 'friend_id');
     }
}
