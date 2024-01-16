<?php

namespace App\Models;

use App\Traits\Models\ActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer                         $id           Id.
 * @property \App\Models\Folder              $folder_id    Folder associated.
 * @property string                          $name         Name.
 * @property string                          $slug         Slug of the name.
 * @property boolean                         $published    Published status.
 * @property \Illuminate\Support\Carbon      $published_at Published date update.
 * @property integer                         $order        Order of the name.
 * @property-read \Illuminate\Support\Carbon $created_at   Created date.
 * @property-read \Illuminate\Support\Carbon $updated_at   Updated date.
 *
 * @method protected static function booted()              Perform any actions required after the model boots.
 * @method private static function setSlug($game)          Set model's slug.
 * @method private static function setPublishedDate($game) Set model's published date.
 * @method private static function setOrder($game)         Set model's order after the last element of the list.
 *
 * @property-read \App\Models\Folder $folder
 * Get Folder that owns the Game (relationship).
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * Get Tags of the Game (relationship).
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Picture[] $pictures
 * Get Pictures of the Game (relationship).
 */
class Game extends Model
{
    use ActivityLog;
    use HasFactory;

    /**
     * The attributes that are fillable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'folder_id',
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
        static::creating(function (self $game) {
            static::setOrder($game);
            static::setPublishedDate($game);
            Picture::renameFolderSavedPictures($game, "default_folder");
        });
        static::updating(function (self $game) {
            static::setPublishedDate($game);
            Picture::renameFolderSavedPictures($game, $game->getOriginal('slug'));
        });
        static::deleting(function (self $game) {
            Tag::removeTags($game);
            Picture::removePictures($game->pictures);
        });
    }

    // * METHODS

    /**
     * Set model's published date.
     *
     * @param \App\Models\Game $game
     * @return void
     */
    private static function setPublishedDate(Game $game): void
    {
        if ($game->published && !$game->getOriginal('published')) {
            $game->published_at = now();
        } elseif (!$game->published) {
            $game->published_at = null;
        }
    }

    /**
     * Set model's order after the last element of the list.
     *
     * @param \App\Models\Game $game
     * @return void
     */
    private static function setOrder(Game $game): void
    {
        $game->order = \intval(self::query()->max('order')) + 1;
    }

    // * RELATIONSHIPS

    /**
     * Get Folder that owns the Game (relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function folder(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * Get Tags of the Game (relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Get Pictures of the Game (relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pictures(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Picture::class);
    }

    /**
     * Get Rank that of the Game (relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|null
     */
    public function rank(): \Illuminate\Database\Eloquent\Relations\BelongsTo|null
    {
        return $this->belongsTo(Folder::class);
    }
}
