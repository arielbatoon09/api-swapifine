<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ReportedUser extends Model
{
    use HasFactory;

    protected $table = "tbl_reported_user";

    protected $fillable = [
        'user_id',
        'reported_by',
        'message',
        'proof_img_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
