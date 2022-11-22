<?php

namespace App\Models;

use App\Lib\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'pictures' => 'array'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();

        static::updating(function (self $game) {
            static::assertNameIsUnique($game->name, $game->id);
            $game->updateImages($game);
        });

        static::deleting(function (self $game) {
            static::assertNameIsUnique($game->name, $game->id);
            $game->updateImages($game);
        });
    }

    // * METHODS

    /**
     * Remove old images.
     *
     * @param Model $game
     * @return void
     */
    private static function updateImages(Model $game): void
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

    /**
     * Asserts using validation that the name is unique
     *
     * @param mixed        $name
     * @param integer|null $id
     * @return void
     * @throws \Illuminate\Validation\ValidationException If a tag name already exists.
     */
    private static function assertNameIsUnique($name, ?int $id = null)
    {
        $table = (new self())->getTable();
        Utils::assertFieldIsUnique($table, 'name', $name, $id);
        Utils::assertFieldIsUnique($table, 'slug', Str::slug($name), $id);
    }

    // * RELATIONSHIPS

    /**
     * Get the Folder that owns the Game.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function folder(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * MorphToMany tags relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
