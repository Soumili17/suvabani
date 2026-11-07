<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPayment extends Model
{
    protected $table = 'membership_payments';

    protected $fillable = [
        'membership_id',
        'razorpay_payment_id',
        'razorpay_subscription_id',
        'razorpay_invoice_id',
        'amount',
        'currency',
        'payment_status',
        'payment_method',
        'paid_at',
        'failure_reason',
        'raw_payload',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'raw_payload' => 'array',
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}
?>
