<?php

namespace App\Models;

use App\Enums\ActivityLogs\ActivityLogsEventEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;

/**
 * @property string                          $model_class Target model.
 * @property string                          $model_id    Id of the target model.
 * @property string                          $event       Event of this activity (ActivityLogsEventEnum).
 * @property string                          $data        Changes.
 * @property-read \Illuminate\Support\Carbon $created_at  Created date.
 *
 * @method public static function addActivity($model, $eventEnum) Add new activity to the activity logs list.
 * @method public static function getValuesChanged($activity, $model, $eventEnum)
 * Get old, new and type of values changed.
 *
 * @property-read \App\Models\User $user User BelongsTo relation.
 */
class ActivityLog extends Model
{
    use HasFactory;
    use Notifiable;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'is_anonymous',
        'model_class',
        'model_id',
        'event',
        'data',
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_anonymous' => 'bool',
        'event'        => ActivityLogsEventEnum::class,
        'data'         => 'json',
        'created_at'   => 'datetime',
    ];

    // * METHODS

    /**
     * Add new activity to the activity logs list.
     *
     * @param \Illuminate\Database\Eloquent\Model           $model
     * @param \App\Enums\ActivityLogs\ActivityLogsEventEnum $eventEnum
     * @return void
     */
    public static function addActivity(Model $model, ActivityLogsEventEnum $eventEnum): void
    {
        $isAnonymous = true;
        /** @var \Illuminate\Database\Eloquent\Model|null */
        $userModel = auth('backend')->user();
        if (is_object($userModel)) {
            $userModel   = $userModel->getKeyForSelectQuery();
            $isAnonymous = false;
        }
        $activity               = new self();
        $activity->user_id      = $userModel;
        $activity->is_console   = app()->runningInConsole();
        $activity->is_anonymous = $isAnonymous;
        $activity->model_class  = \get_class($model);
        $activity->model_id     = $model->getKey();
        $activity->event        = $eventEnum;
        $activity->data         = static::getChangedColumns($activity, $model, $eventEnum);
        $activity->created_at   = Carbon::now();
        $activity->saveOrFail();
    }

    /**
     * Get old, new columns that has changed.
     *
     * @param \self                                         $activity
     * @param \Illuminate\Database\Eloquent\Model           $model
     * @param \App\Enums\ActivityLogs\ActivityLogsEventEnum $eventEnum
     * @return array|null
     */
    public static function getChangedColumns(self $activity, Model $model, ActivityLogsEventEnum $eventEnum): array|null
    {
        $modelClassName = $activity->model_class;
        /** Get type of each fields of the target model */
        $targetModel = $activity->model_class::where(
            (new $modelClassName())->getRouteKeyName(),
            $activity->model_id
        )->first();
        if ($targetModel != null) {
            // phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClassBeforeLastUsed
            $targetModelTypes = collect($targetModel->toArray())
                ->map(function ($field, $fieldIndex) use ($targetModel) {
                    return Schema::getColumnType($targetModel->getTable(), $fieldIndex);
                })->toArray();
            // phpcs:enable
        }
        /** Return old, new and type of values changed */
        return ($eventEnum === ActivityLogsEventEnum::updated) ?
            array_intersect_key($targetModelTypes, $model->getChanges()) : null;
    }

    // * RELATIONS

    /**
     * User BelongsTo relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
