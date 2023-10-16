<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Image;
use App\Models\Post;
use App\Models\Message;

class Inbox extends Model
{
    use HasFactory;

    protected $table = 'tbl_inbox';

    protected $fillable = [
        'inbox_key',
        'user_id',
        'post_item_key',
        'is_read',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function post()
    {
        return $this->hasOne(Post::class, 'item_key', 'post_item_key');
    }
    public function images()
    {
        return $this->hasMany(Image::class, 'post_item_key', 'post_item_key');
    }
    public function message()
    {
        return $this->hasMany(Message::class, 'msg_inbox_key', 'inbox_key');
    }
}
