<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    protected $fillable = [
        'key',
        'expiration_date',
        'owner_id'
    ];
}
