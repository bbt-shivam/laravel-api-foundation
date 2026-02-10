<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_reset_tokens';
    protected $fillable = ['email','token','created_at'];

    protected $casts = ['created_at' => 'datetime'];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
