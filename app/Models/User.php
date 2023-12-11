<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Auth\Notifications\VerifyEmail;
// use Illuminate\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;
use App\Models\ReportedUser;
use App\Models\Ratings;
use App\Models\Verification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tbl_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'is_verified',
        'credits_amount',
        'profile_img',
        'flag',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'id', 'user_id');
    }
    public function countPost()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }
    public function verification()
    {
        return $this->belongsTo(Verification::class, 'id', 'user_id');
    }
    public function ratings()
    {
        return $this->belongsTo(Ratings::class, 'id', 'rated_to_id');
    }
    public function report()
    {
        return $this->belongsTo(ReportedUser::class, 'id', 'user_id');
    }
    
}
