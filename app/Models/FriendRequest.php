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
    public function userReceiver(){
        return $this->belongsTo(User::class,'receiver_id' ,'id');
    }
    public function userSender(){
        return $this->belongsTo(User::class,'sender_id','id');
    }
    public function scopeReceiverIdsForSender(Builder $query,$senderId)
    {
        return $query->where('sender_id', $senderId)->pluck('receiver_id');
    }
    public function scopeShowMyFriendRequest(Builder $query,$receiverId)
    {
        return $query->select('id','sender_id')->where('receiver_id',$receiverId)->with('userSender');
    }
}
