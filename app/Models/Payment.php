<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
    'enquiry_id',
    'payment_mode',
    'amount_paid',
    'notes'
    ];

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class);
    }
}
