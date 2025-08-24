<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WellnessInterest extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'category', 
        'name'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_wellbeing_pillar');
    }
}
