<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'designation',
        'profile_pic',
    ];

    // Auto-append full image URL
    protected $appends = ['profile_pic_url'];

    public function getProfilePicUrlAttribute()
    {
        return $this->profile_pic
            ? asset('storage/' . $this->profile_pic)
            : null;
    }
}