<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = ['donor_id','amount','payment_status','payment_method','receipt_number'];

    public function donor() {
        return $this->belongsTo(Donor::class);
    }
}

