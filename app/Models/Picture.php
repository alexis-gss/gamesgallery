<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
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
 * @method protected static function booted()                       Perform any actions required after the model boots.
 * @method public static function renameFolderSavedPictures($model) Rename the folder where there is saved pictures.
 * @method private static function removePicture($picture)          Delete one specific picture.
 * @method private static function removePictures($pictures)        Remove all pictures previously associated.
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
     * Rename the folder where pictures are saved.
     *
     * @param Model  $model
     * @param string $slug
     * @return void
     */
    public static function renameFolderSavedPictures(Model $model, string $slug)
    {
        if ($slug !== $model->slug) {
            $directory = Storage::disk('public')->path("documents/" . $slug);
            if (is_dir($directory)) {
                rename($directory, Storage::disk('public')->path("documents/" . $model->slug));
            }
        }
    }

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

    /**
     * Remove all pictures previously associated.
     *
     * @param Collection $pictures
     * @return void
     */
    public static function removePictures(Collection $pictures): void
    {
        foreach ($pictures as $picture) {
            $picture->delete();
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
