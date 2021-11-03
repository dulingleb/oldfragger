<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    const OS = [
        0 => 'Android',
        1 => 'iOS',
        2 => 'iPadOS',
        3 => 'Windows'
    ];
}
