<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Inbox;

class Transactions extends Model
{
    use HasFactory;

    protected $table = 'tbl_user_transactions';

    protected $fillable = [
        'user_id',
        'vendor_id',
        'msg_inbox_key',
        'payment_method',
        'delivery_address',
        'user_notes',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id', 'id');
    }
    public function buyer_user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function inbox()
    {
        return $this->hasOne(Inbox::class,'inbox_key', 'msg_inbox_key');
    }
}
