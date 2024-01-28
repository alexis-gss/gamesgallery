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
 * @method static void booted()                                              Perform any actions required after the
 * model boots.
 * @method static void updatePictures(Game $game, array $request)          Differentiate between old and new
 * pictures, remove oldests and save news.
 * @method static void renameFolderSavedPictures(Game $game, string $slug) Rename the folder where there is
 * saved pictures.
 * @method static void removePicture(self $model)                          Delete one specific picture.
 * @method static void removePictures(Collection $pictures)                Remove all pictures previously associated.
 *
 * @property-read \App\Models\Game $game Get the Game that owns the Picture (relationship).
 */
class Picture extends Model
{
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['ratings'];

    /**
     * The attributes that are fillable.
     *
     * @var array<string>
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
            self::removePicture($picture);
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
        (new Picture())->removePictures($picturesAlreadySaved->diff($newPictures));
    }

    /**
     * Rename the folder where pictures are saved.
     *
     * @param \App\Models\Game $game
     * @param string           $slug
     * @return void
     */
    public static function renameFolderSavedPictures(Game $game, string $slug): void
    {
        if ($slug !== $game->slug) {
            $directory = Storage::disk('public')->path("pictures/" . $slug);
            if (is_dir($directory)) {
                rename($directory, Storage::disk('public')->path("pictures/" . $game->slug));
            }
        }
    }

    /**
     * Delete one specific picture.
     *
     * @param self $picture
     * @return void
     */
    private static function removePicture(self $picture): void
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

    /**
     * Get Ratings of the Picture (relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
