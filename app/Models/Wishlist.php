<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'tbl_user_wishlist';

    protected $fillable = [
        'user_id',
        'post_item_id',
    ];
}
