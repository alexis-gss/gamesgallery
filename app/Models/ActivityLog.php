<?php

namespace App\Models;

use App\Enums\ActivityLogs\ActivityLogsEventEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property string                                        $model_class Target model.
 * @property string                                        $model_id    Id of the target model.
 * @property \App\Enums\ActivityLogs\ActivityLogsEventEnum $event       Event of this activity (ActivityLogsEventEnum).
 * @property array                                         $data        Changes.
 * @property-read \Illuminate\Support\Carbon               $created_at  Created date.
 *
 * @property-read \App\Models\User $user User BelongsTo relation.
 */
class ActivityLog extends Model
{
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
        // @phpstan-ignore-next-line
        $activity->created_at = now();
        $activity->saveOrFail();
    }

    /**
     * Get old, new columns that has changed.
     *
     * @param self                                          $activity
     * @param \Illuminate\Database\Eloquent\Model           $model
     * @param \App\Enums\ActivityLogs\ActivityLogsEventEnum $eventEnum
     * @return array
     */
    public static function getChangedColumns(self $activity, Model $model, ActivityLogsEventEnum $eventEnum): array
    {
        $modelClassName = $activity->model_class;
        /** Get type of each fields of the target model */
        /** @var \Illuminate\Database\Eloquent\Model|null $targetModel */
        $targetModel = $activity->model_class::where(
            (new $modelClassName())->getRouteKeyName(),
            $activity->model_id
        )->first();

        if (\is_null($targetModel)) {
            return [];
        }
        $targetModelTypes = collect($targetModel->toArray())
            ->map(fn ($value) => self::getValueType($value))
            ->toArray();
        /** Return old, new and type of values changed */
        return ($eventEnum === ActivityLogsEventEnum::updated) ?
            array_intersect_key($targetModelTypes, $model->getChanges()) : [];
    }


    /**
     * Get a value type as a string
     * ! Use this for display purpose only
     *
     * @param mixed $value
     * @return string
     * @throws \RuntimeException If type is unhlanded.
     * @phpcs:disable Generic.Metrics.CyclomaticComplexity.MaxExceeded
     */
    private static function getValueType(mixed $value): string
    {
        // phpcs:enable
        $type = \gettype($value);
        switch ($type) {
                // phpcs:ignore PSR2.ControlStructures.SwitchDeclaration.TerminatingComment
            case 'string':
                return match (true) {
                    Str::length(\strip_tags($value)) !== Str::length($value) => 'html',
                    Str::startsWith($value, 'storage/modelfiles') => 'file',
                    Str::isUuid($value) => 'uuid',
                    Str::isUlid($value) => 'ulid',
                    Str::isUrl($value) => 'url',
                    Str::isMatch('/^[0-9A-Za-z_-]{10}[048AEIMQUYcgkosw]$/', $value) => 'youtube_video_id',
                    \is_numeric($value) => 'numeric',
                    Str::isJson($value) and
                        (Str::startsWith($value, '[') or Str::startsWith($value, '{')) => 'json',
                    default => 'string'
                };
            case 'NULL':
            case 'object':
            case 'array':
            case 'integer':
            case 'boolean':
                return $type;
            case 'double':
                return is_float($value) ? 'float' : 'double';
            case 'resource (closed)':
            case 'resource':
                throw new \RuntimeException('Laravel model properties should not contain resources !');
            case 'unknown type':
            default:
                throw new \RuntimeException('Unhandled Type ' . \gettype($value));
        } //end switch
    }

    // * RELATIONS

    /**
     * User BelongsTo relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
