<?php

namespace App\Models;

use App\Casts\RgbaColor;
use App\Traits\Models\ActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer                         $id           Id.
 * @property string                          $slug         Slug of the name.
 * @property string                          $name         Name.
 * @property integer                         $color        Color.
 * @property boolean                         $published    Published status.
 * @property \Illuminate\Support\Carbon      $published_at Published date update.
 * @property integer                         $order        Order.
 * @property-read \Illuminate\Support\Carbon $created_at   Created date.
 * @property-read \Illuminate\Support\Carbon $updated_at   Updated date.
 *
 * @method static void booted()                       Perform any actions required after the model boots.
 * @method static void setPublishedDate(self $folder) Set model's published date.
 * @method static void setOrder(self $folder)         Set model's order after the last element of the list.
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
     * @var array<string>
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
     * @var array<string, string>
     */
    protected $casts = [
        'color'        => RgbaColor::class,
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
            self::setOrder($folder);
            self::setPublishedDate($folder);
        });
        static::updating(function (self $folder) {
            self::setPublishedDate($folder);
        });
    }

    // * METHODS

    /**
     * Set model's published date.
     *
     * @param self $folder
     *
     * @return void
     */
    private static function setPublishedDate(self $folder): void
    {
        $folder->published_at = ($folder->published) ? now() : null;
    }

    /**
     * Set model's order after the last element of the list.
     *
     * @param self $folder
     * @return void
     */
    private static function setOrder(self $folder): void
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
