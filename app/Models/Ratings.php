<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Ratings extends Model
{
    use HasFactory;

    protected $table = 'tbl_user_ratings';

    protected $fillable = [
        'rated_by_id',
        'rated_to_id',
        'scale_ratings',
        'comment',
    ];

    public function ratedBy()
    {
        return $this->belongsTo(User::class, 'rated_by_id');
    }
}
