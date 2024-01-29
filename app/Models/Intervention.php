<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Intervention extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = [
        'id', 'health_information_id', 'date', 'time', 'parameter', 'value', 'comment', 'user_id', 'user_erf', 'file',
        'further_treatment', 'user_close', 'date_close', 'time_close', 'comment_close', 'medication', 'health_status_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function health_information(){
        return $this->belongsTo(HealthInformation::class);
    }

    public function health_status(){
        return $this->belongsTo(HealthStatus::class);
    }
}
