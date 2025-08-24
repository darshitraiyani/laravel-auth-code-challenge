<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WellbeingPillar extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_wellbeing_pillar');
    }
}
