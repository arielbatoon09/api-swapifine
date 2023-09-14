<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'tbl_item_image';

    protected $fillable = [
        'post_item_key',
        'post_item_id',
        'img_file_path',
    ];
}
