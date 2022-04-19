<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'recent_issues', 'recent_issues_doctor', 'drugs', 'drugs_only_contact', 'chronicle_diseases'
    ];

    public function allergies(){
        return $this->hasMany(AllergyHealthInformation::class, 'health_information_id');
    }
}
