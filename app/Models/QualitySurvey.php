<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualitySurvey extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_id',
        'q1',
        'q2',
        'q3',
        'q4',
        'q5'
    ];

    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }
}
