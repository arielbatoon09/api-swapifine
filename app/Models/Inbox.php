<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Image;
use App\Models\Post;
use App\Models\Message;
use App\Models\Category;

class Inbox extends Model
{
    use HasFactory;

    protected $table = 'tbl_inbox';

    protected $fillable = [
        'inbox_key',
        'from_id',
        'to_id',
        'post_item_key',
        'read_by_sender',
        'read_by_receiver',
    ];
    public function from_user()
    {
        return $this->belongsTo(User::class, 'from_id', 'id');
    }
    public function to_user()
    {
        return $this->belongsTo(User::class, 'to_id', 'id');
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
    public function category()
    {
        return $this->hasOne(Category::class, 'category_id', 'id');
    }
}
