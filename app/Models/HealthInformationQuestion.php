<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthInformationQuestion extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'answer',
        'health_information_id',
        'question_id'
    ];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function health_information(){
        return $this->belongsTo(HealthInformation::class);
    }
}
