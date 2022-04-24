<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'health_information_id', 'date', 'time', 'incident', 'comment', 'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function health_information(){
        return $this->belongsTo(HealthInformation::class);
    }
}
