<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $fillable = ['user_id','action','url','method','ip_address','payload'];

    protected $casts = [
        'payload' => 'array',
    ];
}
