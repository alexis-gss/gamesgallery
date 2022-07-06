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
     * Delete old images.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::updating(function ($game) {
            if (
                isset($game->getOriginal()['pictures']) &&
                count($game->getOriginal()['pictures']) > 0 &&
                $game->getOriginal()['pictures'] != null
            ) {
                foreach ($game->getOriginal()['pictures'] as $oldImage) {
                    File::delete($oldImage);
                }
            }
        });
    }
}
