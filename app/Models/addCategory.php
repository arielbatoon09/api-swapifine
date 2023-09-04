<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class addCategory extends Model
{
    use HasFactory;

    protected $table = 'tbl_category';

    protected $fillable = [
        'category',
    ];
}
