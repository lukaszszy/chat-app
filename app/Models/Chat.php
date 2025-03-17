<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id',
        'email',
        'gender',
        'age',
        'discipline',
        'title',
        'survFinished',
        'chatFinished',
        'postsurFinished'
    ];

    public $timestamps = true;

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}