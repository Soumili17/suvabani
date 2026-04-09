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
        'declaration_date',
        'razorpay_payment_id',
        'razorpay_subscription_id'
    ];

    protected $casts = [
        'interest' => 'array'
    ];
}