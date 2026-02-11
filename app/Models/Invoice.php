<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'invoice_number',
        'pdf_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // if donor/member uses User model
    }
}
