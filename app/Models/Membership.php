<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [

        'photo',
        'signature',

        'name',
        'parentname',
        'dob',
        'gender',
        'nationality',
        'occupation',
        'address',
        'phone',
        'email',

        'idproof',
        'idnumber',
        'idfile',

        'membership_type',
        'paid_amount',

        'interest',
        'experience',
        'languages',
        'time',
        'reason',

        'ref_name',
        'ref_mobile',

        'declaration_date',

        'razorpay_payment_id',
        'razorpay_subscription_id',

        'membership_id',
        'payment_status',
        'subscription_status',

        'approval_status',
        'approved_at'
    ];
}
