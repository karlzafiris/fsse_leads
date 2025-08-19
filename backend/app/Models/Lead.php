<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Lead extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'leads';
    protected $primaryKey = '_id';
    public $incrementing = false;
    
    protected $fillable = [
        'name',
        'email',
        'consent'
    ];
}
