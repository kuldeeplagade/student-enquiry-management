<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'surname',
        'first_name',
        'middle_name',
        'dob',
        'sex',
        'blood_group',
        'father_mobile',
        'mother_mobile',
        'landline',
        'email',
        'admission_for',
        'sibling1_name',
        'sibling1_sex',
        'sibling1_dob',
        'sibling2_name',
        'sibling2_sex',
        'sibling2_dob',
        'address',
        'state',
        'city',
        'pin',
        'payment_status',
        'payment_mode',
        'amount_paid',
        'total_amount'
    ];
}
