<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'id_card'
    ];

    // Optional: auto-append full image URL
    protected $appends = ['id_card_url'];

    public function getIdCardUrlAttribute()
    {
        return $this->id_card 
            ? asset('storage/' . $this->id_card) 
            : null;
    }
}