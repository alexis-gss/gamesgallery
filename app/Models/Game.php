<?php

namespace App\Models;

use App\Lib\Helpers\ToolboxHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property integer $id
 * @property integer $folder_id
 * @property string $name
 * @property string $slug
 * @property string $pictures
 * @property string $pictures_alt
 * @property string $pictures_title
 * @property boolean $status
 * @property integer $order
 */
class Game extends Model
{
    use HasFactory;

    /**
     * The attributes that are fillable.
     *
     * @var array
     */
    protected $fillable = [
        'folder_id',
        'name',
        'slug',
        'pictures',
        'pictures_alt',
        'pictures_title',
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
            static::setOrder($game);
        });
        static::updating(function (self $game) {
            static::setSlug($game);
            static::assertFieldIsUnique($game->slug, $game->id);
        });
    }

    // * METHODS

    /**
     * Set the slug.
     *
     * @param \App\Models\Game $game
     *
     * @return void
     */
    private static function setSlug(Game $game)
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
     * @param \App\Models\Game $game
     * @return void
     */
    private static function setOrder(Game $game): void
    {
        $game->order = \intval(self::query()->max('order')) + 1;
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
