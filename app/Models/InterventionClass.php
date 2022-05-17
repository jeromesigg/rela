<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterventionClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'Short_name', 'parameter_name', 'value_name'
    ];
}
