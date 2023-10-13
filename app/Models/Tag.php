<?php

namespace App\Models;

use App\Lib\Helpers\ToolboxHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property boolean $published
 * @property date $published_at
 * @property integer $order
 */
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
        'slug',
        'published',
        'published_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'published' => 'bool',
        'published_at' => 'datetime'
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
            static::setPublishedDate($tag);
        });
        static::updating(function (self $tag) {
            static::assertFieldIsUnique($tag->slug, $tag->id);
            static::setPublishedDate($tag);
        });
        static::deleting(function (self $tag) {
            $tag->games()->detach();
        });
    }

    // * METHODS

    /**
     * Set the slug.
     *
     * @param \App\Models\Tag $tag
     *
     * @return void
     */
    private static function setSlug(Tag $tag)
    {
        $tag->slug = Str::slug($tag->name);
    }

    /**
     * Set the published date.
     *
     * @param \App\Models\Tag $tag
     *
     * @return void
     */
    private static function setPublishedDate(Tag $tag)
    {
        $tag->published_at = ($tag->published) ? now() : null;
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
     * @param \App\Models\Tag $tag
     * @return void
     */
    private static function setOrder(Tag $tag): void
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
