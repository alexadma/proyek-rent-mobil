<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'action',
        'description',
        'user',
        'details',
    ];

    protected $casts = [
        'details' => 'array',
    ];

    /**
     * Helper: log aktivitas baru
     */
    public static function log(string $type, string $action, string $description, ?string $user = null, ?array $details = null): static
    {
        return static::create([
            'type' => $type,
            'action' => $action,
            'description' => $description,
            'user' => $user ?? auth('admin')->user()?->nama ?? 'Admin',
            'details' => $details,
        ]);
    }
}
