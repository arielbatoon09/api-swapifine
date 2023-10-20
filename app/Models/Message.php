<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;
use App\Models\Inbox;

class Message extends Model
{
    use HasFactory;

    protected $table = 'tbl_message';

    protected $fillable = [
        'msg_inbox_key',
        'from_id',
        'to_id',
        'message',
    ];

    public function from_user()
    {
        return $this->belongsTo(User::class, 'from_id', 'id');
    }
    public function to_user()
    {
        return $this->belongsTo(User::class, 'to_id', 'id');
    }
    public function inbox()
    {
        return $this->hasOne(Inbox::class, 'inbox_key', 'msg_inbox_key');
    }
    public function post()
    {
        return $this->hasOne(Post::class, 'item_key', 'post_item_key');
    }
}
