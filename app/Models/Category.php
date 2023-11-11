<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Category extends Model
{
    use HasFactory;

    protected $table = 'tbl_category';

    protected $fillable = [
        'category_name',
    ];

    public function post()
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }
}
