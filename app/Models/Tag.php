<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Tag.
 *
 * @property integer                         $id           Id.
 * @property string                          $name         Name
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
 * @method private static function removeTagsFromGame($tag)  Remove a specific tag from all games.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Game[] $games
 * Get Games of the tag (relationship).
 */
class Tag extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'published',
        'published_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'published' => 'bool',
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
            static::setSlug($tag);
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
     * Set model's slug.
     *
     * @param \App\Models\Tag $tag
     *
     * @return void
     */
    private static function setSlug(Tag $tag)
    {
        $tag->slug = Str::slug($tag->name);
    }

    /**
     * Set model's published date.
     *
     * @param \App\Models\Tag $tag
     *
     * @return void
     */
    private static function setPublishedDate(Tag $tag)
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
     * Remove a specific tag from all games.
     *
     * @param \App\Models\Tag $tag
     *
     * @return void
     */
    private static function removeTagsFromGame(Tag $tag)
    {
        $tag->games()->detach();
    }

    // * RELATIONSHIPS

    /**
     * Get Games of the tag (relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function games()
    {
        return $this->morphedByMany(Game::class, 'taggable');
    }
}
