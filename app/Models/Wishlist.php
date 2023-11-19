<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'tbl_user_wishlist';

    protected $fillable = [
        'user_id',
        'post_item_id',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_item_id', 'id'); 
    }
}
