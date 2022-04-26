<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'health_information_id', 'date', 'time', 'parameter', 'value', 'comment', 'user_id', 'observation_class_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function health_information(){
        return $this->belongsTo(HealthInformation::class);
    }

    public function observation_class(){
        return $this->belongsTo(ObservationClass::class);
    }
}
