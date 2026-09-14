<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'api_url',
        'api_key',
        'secret_key',
        'settings',
        'is_active',
    ];
    
    
    protected function casts(): array
    {
        return [
            'api_key' => 'encrypted',
            'secret_key' => 'encrypted',
            'settings' => 'encrypted:array',
            'is_active' => 'boolean',
        ];
    }
}
