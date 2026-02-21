<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
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
        'idproof_other',
        'idnumber',
        'idfile',
        'membership',
        'paidamount',
        'membertype',
        'interest',
        'interest_other',
        'experience',
        'languages',
        'time',
        'reason',
        'ref_name',
        'ref_mobile',
        'declaration_date'
    ];
}
