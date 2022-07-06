<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Game extends Model
{
    /**
     * The attributes that are fillable.
     *
     * @var array
     */
    protected $fillable = [
        'folder_id',
        'name',
        'pictures_alt'
    ];

    /**
     * The attributes that should be cast
     *
     * @var array
     */
    protected $casts = [
        'pictures' => 'array'
    ];

    /**
     * Get the Folder that owns the Game.
     *
     * @return array
     */
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * Actions on update/delete Game model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::updating(function (self $game) {
            $game->updateImages($game);
        });

        static::deleting(function (self $game) {
            $game->updateImages($game);
        });
    }

    /**
     * Remove old images.
     *
     * @param Model $game
     * @return void
     */
    private static function updateImages(Model $game)
    {
        if (
            $game->getOriginal('pictures') and
            count($game->getOriginal('pictures')) > 0 and
            $game->order === $game->getOriginal('order')
        ) {
            foreach ($game->getOriginal('pictures') as $oldImage) {
                File::delete($oldImage);
            }
        }
    }
}
