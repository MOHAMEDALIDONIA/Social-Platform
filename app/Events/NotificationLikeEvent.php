<?php

namespace App\Events;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationLikeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $postId;
    public $LikedPost;
    /**
     * Create a new event instance.
     */
    public function __construct($LikedPost,$postId)
    {
        $this->LikedPost =$LikedPost;
        $this->postId = $postId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
       $post=  Post::find($this->postId);
       
        return [
            'user-like-post'.$post->user->id,
        ];
    }
    public function broadcastAs()
    {
        return 'liked-post';
    }
}
