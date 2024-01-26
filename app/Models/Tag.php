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
 * @method static void booted()                                Perform any actions required after the model boots.
 * @method static void setPublishedDate(self $tag)             Set model's published date.
 * @method static void setOrder(self $tag)                     Set model's order after the last element of the list.
 * @method static void setTags(Model $model, Collection $tags) Set model's tags.
 * @method static void removeTagsFromGame(self $tag)           Remove a specific tag from all games.
 * @method static void removeTags(Model $model)                Remove all tags previously associated.
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
     * @var array<string>
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
     * @var array<string, string>
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
            self::setOrder($tag);
            self::setPublishedDate($tag);
        });
        static::updating(function (self $tag) {
            self::setPublishedDate($tag);
        });
        static::deleting(function (self $tag) {
            self::removeTagsFromGame($tag);
        });
    }

    // * METHODS

    /**
     * Set model's published date.
     *
     * @param self $tag
     *
     * @return void
     */
    private static function setPublishedDate(self $tag): void
    {
        $tag->published_at = ($tag->published) ? now() : null;
    }

    /**
     * Set order after the last element of the list.
     *
     * @param self $tag
     * @return void
     */
    private static function setOrder(self $tag): void
    {
        $tag->order = \intval(self::query()->max('order')) + 1;
    }

    /**
     * Set model's tags.
     *
     * @param \App\Models\Game               $game
     * @param \Illuminate\Support\Collection $tags
     *
     * @return void
     */
    public static function setTags(Game $game, Collection $tags): void
    {
        $game->tags()->sync($tags->pluck('id'));
    }

    /**
     * Remove a specific tag from all games.
     *
     * @param \App\Models\Tag $tag
     * @return void
     */
    private static function removeTagsFromGame(Tag $tag): void
    {
        $tag->games()->detach();
    }

    /**
     * Remove all tags previously associated.
     *
     * @param \App\Models\Game $game
     * @return void
     */
    public static function removeTags(Game $game): void
    {
        $game->tags()->sync([]);
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
