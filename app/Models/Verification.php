<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Verification extends Model
{
    use HasFactory;

    protected $table = 'tbl_verification';
    protected $fillable = [
        'user_id',
        'legal_name',
        'address',
        'city',
        'zip_code',
        'dob',
        'img_file_path',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
