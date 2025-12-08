<?php

namespace App\Modules\Shared\Infrastructure\Traits;
use Illuminate\Support\Facades\Auth;

trait AssignAuditFields
{
        public static function bootAssignAuditFields(): void
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
                $model->updated_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }
}
