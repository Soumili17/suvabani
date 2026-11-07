<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table = 'memberships';

    protected $fillable = [
        'photo',
        'signature',
        'fullname',
        'dob',
        'gender',
        'blood_group',
        'nationality',
        'occupation',
        'address',
        'phone',
        'email',
        'idproof',
        'idnumber',
        'idfile',
        'membership',
        'membertype',
        'paidamount',
        'interest',
        'interest_other',
        'experience',
        'languages',
        'time',
        'reason',
        'ref_name',
        'ref_mobile',
        'referral_code',
        'declaration_date',
        'razorpay_payment_id',
        'razorpay_subscription_id'
    ];

    protected $casts = [
        'interest' => 'array'
    ];

    /**
     * Accessor for membership_type (Paid or Non-Paid)
     */
    public function getMembershipTypeAttribute()
    {
        return $this->attributes['membership'] ?? 'Non-Paid';
    }

    /**
     * Accessor for 1st Payment Date
     */
    public function getFirstPaymentDateAttribute()
    {
        if (($this->attributes['membership'] ?? '') === 'Paid') {
            return $this->created_at ? $this->created_at->format('d M Y') : 'N/A';
        }
        return 'N/A';
    }
    /**
    * Get all payment records for this membership.
    */
    public function payments()
    {
        return $this->hasMany(\App\Models\MembershipPayment::class);
    }

}