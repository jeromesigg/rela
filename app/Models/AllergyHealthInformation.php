<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllergyHealthInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'health_information_id', 'allergy_id', 'comment'
    ];

    public function health_information(){
        return $this->belongsTo(HealthInformation::class);
    }

    public function allergy(){
        return $this->belongsTo(Allergy::class);
    }
}
