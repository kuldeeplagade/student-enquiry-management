<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminActivity extends Model
{
    protected $fillable = [
        'user_id',
        'activity_type',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
