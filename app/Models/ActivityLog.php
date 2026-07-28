<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_name',
        'action',
        'model_type',
        'model_id',
        'description',
        'ip_address',
    ];

    /**
     * Helper: catat log aktivitas
     */
    public static function record(string $action, string $modelType, int|null $modelId, string $description): void
    {
        $userName = 'System';
        if (auth()->check()) {
            $userName = auth()->user()->name;
        }

        static::create([
            'user_name'   => $userName,
            'action'      => $action,
            'model_type'  => $modelType,
            'model_id'    => $modelId,
            'description' => $description,
            'ip_address'  => request()->ip(),
        ]);
    }
}
