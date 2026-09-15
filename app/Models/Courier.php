<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    
    const PROVIDERS = ['steadfast', 'pathao', 'redx', 'ecourier'];


    protected $fillable = [
        'name',
        'provider',
        'api_url',
        'api_key',
        'secret_key',
        'client_id',
        'client_secret',
        'username',
        'password',
        'is_active',
        'is_default',
        'notes',
    ];

    protected $casts = [
        'api_key'       => 'encrypted',
        'secret_key'    => 'encrypted',
        'client_id'     => 'encrypted',
        'client_secret' => 'encrypted',
        'username'      => 'encrypted',
        'password'      => 'encrypted',
        'is_active'     => 'boolean',
        'is_default'    => 'boolean',
    ];

    protected $hidden = [
        'api_key',
        'secret_key',
        'client_id',
        'client_secret',
        'username',
        'password',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}