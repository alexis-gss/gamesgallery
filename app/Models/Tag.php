<?php

namespace App\Models;

use App\Lib\Helpers\ToolboxHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (self $tag) {
            static::setSlug($tag);
            static::assertFieldIsUnique($tag->slug);
            static::setOrder($tag);
        });
        static::updating(function (self $tag) {
            static::assertFieldIsUnique($tag->slug, $tag->id);
        });
    }

    // * METHODS

    /**
     * Set the slug.
     *
     * @param \Illuminate\Database\Eloquent\Model $tag
     *
     * @return void
     */
    private static function setSlug(Model $tag)
    {
        $tag->slug = Str::slug($tag->name);
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
     * @param \Illuminate\Database\Eloquent\Model $tag
     * @return void
     */
    public function setOrder(Model $tag): void
    {
        $tag->order = \intval(self::query()->max('order')) + 1;
    }

    // * RELATIONSHIPS

    /**
     * MorphToMany games relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function games()
    {
        return $this->morphedByMany(Game::class, 'taggable');
    }
}
