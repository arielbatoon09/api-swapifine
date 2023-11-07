<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseCredits extends Model
{
    use HasFactory;

    protected $table = 'tbl_purchase_credits';

    protected $fillable = [
        'user_id',
        'ref_key',
        'checkout_session_id',
        'purchase_name',
        'description',
        'payment_method',
        'checkout_url',
        'amount',
        'status',
    ];
}
