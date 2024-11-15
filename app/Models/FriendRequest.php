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
    public function scopeReceiverIdsForSender(Builder $query,$senderId)
    {
        return $query->where('sender_id', $senderId)->pluck('receiver_id');
    }
}
