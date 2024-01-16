<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * @property integer                         $id           Id.
 * @property \App\Models\Game                $game_id      Game associated.
 * @property string                          $uuid         Uuid.
 * @property string                          $label        Label.
 * @property boolean                         $published    Published status.
 * @property-read \Illuminate\Support\Carbon $created_at   Created date.
 * @property-read \Illuminate\Support\Carbon $updated_at   Updated date.
 *
 * @method protected static function booted()                       Perform any actions required after the model boots.
 * @method public static function updatePictures($game, $request)   Differentiate between old and new pictures, remove
 * oldests and save news.
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
                $getPicture = Picture::where('game_id', $game->getKey())
                    ->where('uuid', $request['uuid'][$key])
                    ->first();
                if (is_null($getPicture)) {
                    $picture            = new Picture();
                    $picture->game_id   = $game->getKey();
                    $picture->uuid      = $request['uuid'][$key];
                    $picture->published = true;
                } else {
                    $picture = $getPicture;
                }
                $picture->label = pathinfo($request['label'][$key])['filename'];
                $picture->saveOrFail();
                $newPictures->add($picture);
            } //end foreach
        } //end if
        Picture::removePictures($picturesAlreadySaved->diff($newPictures));
    }

    /**
     * Rename the folder where pictures are saved.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $slug
     * @return void
     */
    public static function renameFolderSavedPictures(Model $model, string $slug): void
    {
        if ($slug !== $model->slug) {
            $directory = Storage::disk('public')->path("pictures/" . $slug);
            if (is_dir($directory)) {
                rename($directory, Storage::disk('public')->path("pictures/" . $model->slug));
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
        $picture  = Picture::query()->where('id', $picture->getKey())->with('game')->first();
        $pathFile = "pictures/" . $picture->game->slug . "/" . $picture->uuid . ".webp";
        if (Storage::disk('public')->exists($pathFile)) {
            Storage::disk('public')->delete($pathFile);
        }
    }

    /**
     * Remove all pictures previously associated.
     *
     * @param \Illuminate\Database\Eloquent\Collection $pictures
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
