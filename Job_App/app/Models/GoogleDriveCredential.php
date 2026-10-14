<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleDriveCredential extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'connectedByUserId',
        'accessToken',
        'refreshToken',
        'expiresAt',
    ];

    protected $hidden = [
        'accessToken',
        'refreshToken',
    ];

    protected function casts(): array
    {
        return [
            'accessToken' => 'encrypted',
            'refreshToken' => 'encrypted',
            'expiresAt' => 'datetime',
        ];
    }
}
