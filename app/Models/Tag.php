<?php

namespace App\Models;

use App\Traits\Models\ActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property integer                         $id           Id.
 * @property string                          $name         Name.
 * @property string                          $slug         Slug of the name.
 * @property boolean                         $published    Published status.
 * @property \Illuminate\Support\Carbon      $published_at Published date update.
 * @property integer                         $order        Order of the name.
 * @property-read \Illuminate\Support\Carbon $created_at   Created date.
 * @property-read \Illuminate\Support\Carbon $updated_at   Updated date.
 *
 * @method protected static function booted()                Perform any actions required after the model boots.
 * @method private static function setSlug($folder)          Set model's slug.
 * @method private static function setPublishedDate($folder) Set model's published date.
 * @method private static function setOrder($folder)         Set model's order after the last element of the list.
 * @method public static function setTags($model, $tags)     Set model's tags.
 * @method private static function removeTagsFromGame($tag)  Remove a specific tag from all games.
 * @method public static function removeTags($model)        Remove all tags previously associated.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Game[] $games
 * Get Games of the tag (relationship).
 */
class Tag extends Model
{
    use ActivityLog;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'name',
        'published',
        'published_at',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'published'    => 'bool',
        'published_at' => 'datetime'
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (self $tag) {
            static::setOrder($tag);
            static::setPublishedDate($tag);
        });
        static::updating(function (self $tag) {
            static::setPublishedDate($tag);
        });
        static::deleting(function (self $tag) {
            static::removeTagsFromGame($tag);
        });
    }

    // * METHODS

    /**
     * Set model's published date.
     *
     * @param \App\Models\Tag $tag
     *
     * @return void
     */
    private static function setPublishedDate(Tag $tag): void
    {
        $tag->published_at = ($tag->published) ? now() : null;
    }

    /**
     * Set order after the last element of the list.
     *
     * @param \App\Models\Tag $tag
     * @return void
     */
    private static function setOrder(Tag $tag): void
    {
        $tag->order = \intval(self::query()->max('order')) + 1;
    }

    /**
     * Set model's tags.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param \Illuminate\Support\Collection      $tags
     *
     * @return void
     */
    public static function setTags(Model $model, Collection $tags): void
    {
        $model->tags()->sync($tags->pluck('id'));
    }

    /**
     * Remove a specific tag from all games.
     *
     * @param \App\Models\Tag $tag
     *
     * @return void
     */
    private static function removeTagsFromGame(Tag $tag): void
    {
        $tag->games()->detach();
    }

    /**
     * Remove all tags previously associated.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public static function removeTags(Model $model): void
    {
        $model->tags()->sync([]);
    }

    // * RELATIONSHIPS

    /**
     * Get Games of the tag (relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function games(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(Game::class, 'taggable');
    }
}
