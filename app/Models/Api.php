<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    protected $table = 'api';

    protected $fillable = [
        'id',
        'document_name',
        'call',
        'document_data',
        'placeholder'
    ];
}
