<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Picture of a specific game.
 *
 * @property integer                         $id           Id.
 * @property \App\Models\Game                $game_id      Game associated.
 * @property string                          $uuid         Uuid.
 * @property string                          $label        Label.
 * @property string                          $type         Type (extension).
 * @property boolean                         $published    Published status.
 * @property-read \Illuminate\Support\Carbon $created_at   Created date.
 * @property-read \Illuminate\Support\Carbon $updated_at   Updated date.
 *
 * @method protected static function booted()              Perform any actions required after the model boots.
 * @method private static function removePicture($picture) Delete one specific picture.
 *
 * @property-read \App\Models\Game $game Get the Game that owns the Picture (relationship).
 */
class Picture extends Model
{
    /**
     * The attributes that are fillable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'uuid',
        'label',
        'type',
        'published',
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::deleting(function (self $picture) {
            static::removePicture($picture);
        });
    }

    // * METHODS

    /**
     * Delete one specific picture.
     *
     * @param \App\Models\Picture $picture
     * @return void
     */
    private static function removePicture(Picture $picture): void
    {
        $pathFile = "documents/" . $picture->game->slug . "/" . $picture->uuid . "." . $picture->type;
        if (Storage::disk('public')->exists($pathFile)) {
            Storage::disk('public')->delete($pathFile);
        }
    }

    // * RELATIONSHIPS

    /**
     * Get the Game that owns the Picture (relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
