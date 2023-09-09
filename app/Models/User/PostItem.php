<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\PostImage;

class PostItem extends Model
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
        'item_price',
        'item_quantity',
        'condition',
        'item_for_type',
        'delivery_type',
    ];

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }
}
