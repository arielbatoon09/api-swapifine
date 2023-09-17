<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    use HasFactory;
    protected $table = 'tbl_personal_info';

    protected $fillable = [
        'user_id',
        'legalname',
        'birthdate',
        'card_id_img',
        'verification_status',
    ];
}
