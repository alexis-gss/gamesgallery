<?php

namespace App\Observers;

use App\Enums\ActivityLogs\ActivityLogsEventEnum;
use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class ModelObserver
{
    /**
     * Handle the model "created" event.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public static function created(Model $model): void
    {
        ActivityLog::addActivity($model, ActivityLogsEventEnum::created);
    }

    /**
     * Handle the model "updated" event.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public static function updated(Model $model): void
    {
        ActivityLog::addActivity($model, ActivityLogsEventEnum::updated);
    }

    /**
     * Handle the model "duplicated" event.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public static function duplicated(Model $model): void
    {
        ActivityLog::addActivity($model, ActivityLogsEventEnum::duplicated);
    }

    /**
     * Handle the model "deleted" event.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public static function deleted(Model $model): void
    {
        ActivityLog::addActivity($model, ActivityLogsEventEnum::deleted);
    }
}
