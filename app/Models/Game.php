<?php

namespace App\Models;

use App\Traits\Models\ActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Game.
 *
 * @property integer                         $id           Id.
 * @property \App\Models\Folder              $folder_id    Folder associated.
 * @property string                          $name         Name
 * @property string                          $slug         Slug of the name.
 * @property boolean                         $published    Published status.
 * @property \Illuminate\Support\Carbon      $published_at Published date update.
 * @property integer                         $order        Order of the name.
 * @property-read \Illuminate\Support\Carbon $created_at   Created date.
 * @property-read \Illuminate\Support\Carbon $updated_at   Updated date.
 *
 * @method protected static function booted()                     Perform any actions required after the model boots.
 * @method private static function setSlug($game)                 Set model's slug.
 * @method private static function setPublishedDate($game)        Set model's published date.
 * @method private static function setOrder($game)                Set model's order after the last element of the list.
 * @method public static function updatePictures($game, $request) Differentiate between old and new pictures, remove
 * oldests and save news.
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
        'folder_id',
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
        static::creating(function (self $game) {
            static::setSlug($game);
            static::setOrder($game);
            static::setPublishedDate($game);
            Picture::renameFolderSavedPictures($game, "default_folder");
        });
        static::updating(function (self $game) {
            static::setSlug($game);
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
     * Set model's slug.
     *
     * @param \App\Models\Game $game
     *
     * @return void
     */
    private static function setSlug(Game $game)
    {
        $game->slug = Str::slug($game->name);
    }

    /**
     * Set model's published date.
     *
     * @param \App\Models\Game $game
     * @return void
     */
    private static function setPublishedDate(Game $game)
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

    /**
     * Differentiate between old and new pictures,
     * remove oldests and save news.
     *
     * @param \App\Models\Game $game
     * @param array            $request
     * @return void
     */
    public static function updatePictures(Game $game, array $request): void
    {
        $picturesAlreadySaved = $game->pictures;
        $newPictures          = collect();
        if (isset($request['uuid'])) {
            foreach ($request['uuid'] as $key => $value) {
                $getPicture = Picture::where('game_id', $game->id)
                    ->where('uuid', $request['uuid'][$key])
                    ->first();
                if (is_null($getPicture)) {
                    $picture            = new Picture();
                    $picture->game_id   = $game->id;
                    $picture->uuid      = $request['uuid'][$key];
                    $picture->published = true;
                } else {
                    $picture = $getPicture;
                }
                $picture->label = $request['label'][$key];
                $picture->type  = pathinfo($picture->label, PATHINFO_EXTENSION);
                $picture->saveOrFail();
                $newPictures->add($picture);
            } //end foreach
        } //end if
        Picture::removePictures($picturesAlreadySaved->diff($newPictures));
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
}
