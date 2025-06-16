<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'gender',
        'age',
        'discipline',
        'title',
    ];

    public $timestamps = true;

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function qualitySurveys()
    {
    return $this->hasOne(QualitySurvey::class);
    }
}