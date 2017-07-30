<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    protected $table = 'api';

    protected $guarded = [];

    public function setApiNameAttribute($value)
    {
        $this->attributes['api_name'] = strtoupper($value);
    }
}
