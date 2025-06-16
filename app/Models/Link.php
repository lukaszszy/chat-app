<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'email',
        'url',
        'linkClicked'
    ];

    public $timestamps = true;
}