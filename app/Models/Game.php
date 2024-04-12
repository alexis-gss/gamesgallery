<?php

namespace App\Models;

use App\Traits\Models\ActivityLog;
use App\Traits\Models\SchemaOrg;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\SchemaOrg\Schema;

/**
 * @property integer                         $id           Id.
 * @property \App\Models\Folder              $folder_id    Folder associated.
 * @property string                          $name         Name.
 * @property string                          $slug         Slug of the name.
 * @property boolean                         $published    Published status.
 * @property \Illuminate\Support\Carbon|null $published_at Published date update.
 * @property integer                         $order        Order.
 * @property-read \Illuminate\Support\Carbon $created_at   Created date.
 * @property-read \Illuminate\Support\Carbon $updated_at   Updated date.
 *
 * @method static void booted()                     Perform any actions required after the model boots.
 * @method static void setPublishedDate(self $game) Set model's published date.
 * @method static void setOrder(self $game)         Set model's order after the last element of the list.
 * @method \Spatie\SchemaOrg\WebPage toSchemaOrg()  Set micro data.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ActivityLog[] $activityLogs
 * Get Activities of the Game (morph-to-many relationship).
 * @property-read \App\Models\Folder $folder
 * Get Folder that owns the Game (belongs-to relationship).
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * Get Tags of the Game (morph-to-many relationship).
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Picture[] $pictures
 * Get Pictures of the Game (has-many relationship).
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Rank[] $rank
 * Get Rank of the Game (belongs-to relationship).
 */
class Game extends Model
{
    use ActivityLog;
    use HasFactory;
    use SchemaOrg;

    /**
     * The attributes that are fillable.
     *
     * @var array<int, string>
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
     * @var array<string, string>
     */
    protected $casts = [
        'published'    => 'boolean',
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
            self::setOrder($game);
            self::setPublishedDate($game);
            (new Picture())->renameFolderSavedPictures($game, "default_folder");
        });
        static::updating(function (self $game) {
            self::setPublishedDate($game);
            (new Picture())->renameFolderSavedPictures($game, $game->getOriginal('slug'));
        });
        static::deleting(function (self $game) {
            (new Tag())->removeTags($game);
            (new Picture())->removePictures($game->pictures);
        });
    }

    // * METHODS

    /**
     * Set model's published date.
     *
     * @param self $game
     * @return void
     */
    private static function setPublishedDate(self $game): void
    {
        if ($game->published && !$game->getOriginal('published')) {
            $game->published_at = Carbon::now();
        } elseif (!$game->published) {
            $game->published_at = null;
        }
    }

    /**
     * Set model's order after the last element of the list.
     *
     * @param self $game
     * @return void
     */
    private static function setOrder(self $game): void
    {
        $game->order = \intval(self::query()->max('order')) + 1;
    }

    /**
     * Set micro data.
     *
     * @return \Spatie\SchemaOrg\WebPage
     */
    public function toSchemaOrg(): \Spatie\SchemaOrg\WebPage
    {
        $schema = Schema::WebPage()
            ->inLanguage(config('app.locale'))
            ->datePublished($this->published_at)
            ->genre("Game image gallery")
            ->headline($this->name)
            ->isPartOf($this->folder->name)
            ->relatedLink(route('fo.games.show', $this));
        if ($this->pictures->first()) {
            $schema->image(
                sprintf(
                    '%s/storage/pictures/%s/%s',
                    route("fo.games.index"),
                    $this->slug,
                    $this->pictures->first()->uuid . ".webp"
                )
            );
        }
        return $schema
            ->about(
                Schema::Thing()
                    ->name($this->name)
            )
            ->reviewedBy($this->toPersonSchema())
            ->editor($this->toPersonSchema())
            ->author($this->toPersonSchema());
    }

    // * RELATIONSHIPS

    /**
     * Get Folder that owns the Game (belongs-to relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function folder(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * Get Tags of the Game (morph-to-many relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Get Pictures of the Game (has-many relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pictures(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Picture::class);
    }

    /**
     * Get Rank of the Game (belongs-to relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|null
     */
    public function rank(): \Illuminate\Database\Eloquent\Relations\BelongsTo|null
    {
        return $this->belongsTo(Rank::class);
    }
}
