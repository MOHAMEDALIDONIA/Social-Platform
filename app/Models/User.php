<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Policies\UserPolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'bio'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

 

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
  
    public function friends()
    {
        return $this->hasMany(FriendConnection::class, 'user_id','id');
    }
    public function scopeSuggestedConnections(Builder $query, $userId)
    {
        $friendIds = FriendConnection::where('user_id', $userId)->pluck('friend_id');
        $requestReceiverIds = FriendRequest::where('sender_id', $userId)->pluck('receiver_id');
    
        return $query->where('id', '!=', $userId)
                     ->whereNotIn('id', $friendIds)
                     ->whereNotIn('id', $requestReceiverIds);
    }
    public function scopeFriendslist(Builder $query, $userId)
    {
      return $query->whereIn('id', function ($query) use ($userId){
                    $query->select('friend_id')
                        ->from('friend_connections')
                        ->where('user_id', $userId)
                        ->union(
                            DB::table('friend_connections')
                            ->select('user_id')
                            ->where('friend_id', $userId)
                        );
            });
    }
    public function likes(){
        return $this->hasMany(Like::class,'user_id','id');
    }
    public function scopeSearch(Builder $query , $request){
      return $query->where('name','LIKE','%'.$request->search.'%')
                    ->orWhere('email','LIKE','%'.$request->search.'%')
                    ->latest();
    }
}
