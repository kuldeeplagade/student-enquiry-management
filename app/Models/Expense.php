<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
    'title', 
    'amount',
    'payment_mode',
    'category',
    'branch_name',
    'date',
    'notes'
];
}
