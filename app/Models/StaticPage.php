<?php

namespace App\Models;

use App\Enums\Pages\StaticPageTypeEnum;
use App\Traits\Models\ActivityLog;
use App\Traits\Models\SchemaOrg;
use Illuminate\Database\Eloquent\Model;
use Spatie\SchemaOrg\Schema;

/**
 * @property \App\Enums\StaticPageType       $type            Page type (StaticPageTypeEnum).
 * @property string                          $seo_title       Seo title about 70 chars as recommended.
 * @property string                          $seo_description Seo description about 160 chars as recommended.
 * @property string                          $title           Title for the page.
 * @property integer                         $order           Order of the page.
 * @property-read \Illuminate\Support\Carbon $created_at      Created date.
 * @property-read \Illuminate\Support\Carbon $updated_at      Updated date.
 *
 * @method protected static function booted() Perform any actions required after the model boots.
 * @method public function toSchemaOrg()      Set micro data.
 */
class StaticPage extends Model
{
    use ActivityLog;
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
            ->relatedLink(route('fo.static_pages.show', $this))
            ->isAccessibleForFree(true)
            ->headline($this->seo_description)
            ->mainEntityOfPage(route('fo.static_pages.show', $this))
            ->publisher($this->toPersonSchema())
            ->author($this->toPersonSchema());
    }
}
