<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserInvitation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'first_name', 'last_name', 'email','company_name','token', 'status','token_expires_at','used_at'
    ];

    protected $casts = [
        'token_expires_at' => 'datetime',
        'used_at'  => 'datetime'
    ];
}
