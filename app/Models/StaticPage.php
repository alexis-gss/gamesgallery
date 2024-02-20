<?php

namespace App\Models;

use App\Enums\Pages\StaticPageTypeEnum;
use App\Traits\Models\ActivityLog;
use App\Traits\Models\HasTranslations;
use App\Traits\Models\SchemaOrg;
use Illuminate\Database\Eloquent\Model;
use Spatie\SchemaOrg\Schema;

/**
 * @property \App\Enums\Pages\StaticPageTypeEnum $type            Page type.
 * @property string                              $seo_title       Page seo title.
 * @property string                              $seo_description Page seo description.
 * @property string                              $title           Page title.
 * @property integer                             $order           Page order.
 * @property-read \Illuminate\Support\Carbon     $created_at      Created date.
 * @property-read \Illuminate\Support\Carbon     $updated_at      Updated date.
 *
 * @method static void booted()                    Perform any actions required after the model boots.
 * @method \Spatie\SchemaOrg\WebPage toSchemaOrg() Set micro data.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ActivityLog[] $activityLogs
 * Get Activities of the Static page (morph-to-many relationship).
 */
class StaticPage extends Model
{
    use ActivityLog;
    use HasTranslations;
    use SchemaOrg;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'seo_title',
        'seo_description',
        'title',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => StaticPageTypeEnum::class,
    ];

    /**
     * Translatable fields.
     *
     * @var array
     */
    public $translatable = [
        'seo_title',
        'seo_description',
        'title',
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function () {
            throw new \RuntimeException(__('crud.messages.cannot_event_on_model', [
                'event' => __('crud.actions.create'),
                'model' => trans_choice('models.static_page', 1)
            ]));
        });
        static::deleting(function () {
            throw new \RuntimeException(__('crud.messages.cannot_event_on_model', [
                'event' => __('crud.actions.delete'),
                'model' => trans_choice('models.static_page', 1)
            ]));
        });
    }

    /**
     * Set micro data.
     *
     * @return \Spatie\SchemaOrg\WebPage
     */
    public function toSchemaOrg(): \Spatie\SchemaOrg\WebPage
    {
        return Schema::WebPage()
            ->inLanguage(config('app.locale'))
            ->relatedLink(route($this->type->routeName()))
            ->isAccessibleForFree(true)
            ->headline($this->seo_description)
            ->mainEntityOfPage(route($this->type->routeName()))
            ->publisher($this->toPersonSchema())
            ->author($this->toPersonSchema());
    }
}
