<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Password_resets extends Model
{
    protected $fillable = [
        'email',
        'token',
    ];
}
