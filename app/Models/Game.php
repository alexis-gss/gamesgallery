<?php

namespace App\Models;

use App\Lib\Helpers\ToolboxHelper;
use Illuminate\Database\Eloquent\Model;
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
        'slug',
        'pictures_alt',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'pictures' => 'array',
        'status' => 'bool'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (self $game) {
            static::setSlug($game);
            static::assertFieldIsUnique($game->slug);
            static::setAttributeAlt($game);
            static::setFolderId($game);
            static::setOrder($game);
        });
        static::updating(function (self $game) {
            static::setSlug($game);
            static::assertFieldIsUnique($game->slug, $game->id);
            static::setAttributeAlt($game);
            static::setFolderId($game);
        });
    }

    // * METHODS

    /**
     * Set the slug.
     *
     * @param \Illuminate\Database\Eloquent\Model $game
     *
     * @return void
     */
    private static function setSlug(Model $game)
    {
        $game->slug = Str::slug($game->name);
    }

    /**
     * Asserts using validation that the field is unique.
     *
     * @param string       $slug
     * @param integer|null $id
     * @return void
     * @throws \Illuminate\Validation\ValidationException If field already exists.
     */
    private static function assertFieldIsUnique(string $slug, ?int $id = null)
    {
        $table = (new self())->getTable();
        ToolboxHelper::assertFieldIsUnique($table, 'slug', $slug, $id);
    }

    /**
     * Set order after the last element of the list.
     *
     * @param \Illuminate\Database\Eloquent\Model $game
     * @return void
     */
    private function setOrder(Model $game): void
    {
        $game->order = \intval(self::query()->max('order')) + 1;
    }

    /**
     * Set 'alt' attribute for the game picture.
     *
     * @param \Illuminate\Database\Eloquent\Model $game
     * @return void
     */
    public function setAttributeAlt(Model $game): void
    {
        $game->pictures_alt = "Image of the " . $game->name . " game";
    }

    /**
     * Set folder_id by null depending on specific condition.
     *
     * @param \Illuminate\Database\Eloquent\Model $game
     * @return void
     */
    public function setFolderId(Model $game): void
    {
        if ($game->folder_id == "no_associated_folder") {
            $game->folder_id = null;
        };
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
     * MorphToMany tags relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
