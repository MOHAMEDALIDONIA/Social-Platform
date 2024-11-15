<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    use HasFactory;
    protected $table = "friend_requests";
    protected $fillable = [
       'sender_id',
       'receiver_id',
       'status'
    ];
    public function receiver(){
        return $this->belongsTo(User::class,'receiver_id' ,'id');
    }
    public function sender(){
        return $this->belongsTo(User::class,'sender_id','id');
    }
    public function scopeShowMyFriendRequest(Builder $query,$receiverId)
    {
        return $query->select('id','sender_id')->where('receiver_id',$receiverId)->with('userSender');
    }
}
