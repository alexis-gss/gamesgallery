<?php

namespace App\Models;

use App\Traits\Models\ActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Folder of games.
 *
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
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Game[] $games
 * Get Games of the Folder (relationship).
 */
class Folder extends Model
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
        'name',
        'color',
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
        static::creating(function (self $folder) {
            static::setOrder($folder);
            static::setPublishedDate($folder);
        });
        static::updating(function (self $folder) {
            static::setPublishedDate($folder);
        });
    }

    // * METHODS

    /**
     * Set model's published date.
     *
     * @param \App\Models\Folder $folder
     *
     * @return void
     */
    private static function setPublishedDate(Folder $folder): void
    {
        $folder->published_at = ($folder->published) ? now() : null;
    }

    /**
     * Set model's order after the last element of the list.
     *
     * @param \App\Models\Folder $folder
     * @return void
     */
    private static function setOrder(Folder $folder): void
    {
        $folder->order = \intval(self::query()->max('order')) + 1;
    }

    // * RELATIONSHIPS

    /**
     * Get Games of the Folder (relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function games(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Game::class);
    }
}
