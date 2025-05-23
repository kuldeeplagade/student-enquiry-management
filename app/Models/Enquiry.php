<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
    
    protected $fillable= [
        "candidate_name",
        "dob",
        "parent_contact",
        "admission_for"
    ];
}
