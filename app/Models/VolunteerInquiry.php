<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile_no',
        'alt_mobile_no',
        'email',
        'address',
        'pin_code',
        'aadhar_card_path',
        'pan_card_path',
        'image_path',
    ];
}
