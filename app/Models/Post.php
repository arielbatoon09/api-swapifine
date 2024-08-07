<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Image;
use App\Models\Location;
use App\Models\Wishlist;

class Post extends Model
{
    use HasFactory;

    protected $table = 'tbl_post_item';

    protected $fillable = [
        'item_key',
        'user_id',
        'category_id',
        'location_id',
        'item_name',
        'item_description',
        'item_stocks',
        'condition',
        'item_for_type',
        'item_cash_value',
        'count_favorites',
        'is_available',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function images()
    {
        return $this->hasMany(Image::class, 'post_item_key', 'item_key');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
    public function wishlist()
    {
        return $this->hasOne(Wishlist::class, 'post_item_id', 'id');
    }
}
