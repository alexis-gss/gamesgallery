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
class Folder extends Model
{
    use HasFactory;

    /**
     * The attributes that are fillable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'color',
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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (self $folder) {
            static::setSlug($folder);
            static::assertFieldIsUnique($folder->slug);
            static::setOrder($folder);
            static::setPublishedDate($folder);
        });
        static::updating(function (self $folder) {
            static::setSlug($folder);
            static::assertFieldIsUnique($folder->slug, $folder->id);
            static::setPublishedDate($folder);
        });
    }

    // * METHODS

    /**
     * Set the slug.
     *
     * @param \App\Models\Folder $folder
     *
     * @return void
     */
    private static function setSlug(Folder $folder)
    {
        $folder->slug = Str::slug($folder->name);
    }

    /**
     * Set the published date.
     *
     * @param \App\Models\Folder $folder
     *
     * @return void
     */
    private static function setPublishedDate(Folder $folder)
    {
        $folder->published_at = ($folder->published) ? now() : null;
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
     * @param \App\Models\Folder $folder
     * @return void
     */
    private static function setOrder(Folder $folder): void
    {
        $folder->order = \intval(self::query()->max('order')) + 1;
    }

    // * RELATIONSHIPS

    /**
     * Get Games for the Range.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function games(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Game::class);
    }
}
