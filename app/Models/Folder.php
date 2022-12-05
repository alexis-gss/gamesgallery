<?php

namespace App\Models;

use App\Lib\Helpers\ToolboxHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Folder extends Model
{
    /**
     * The attributes that are fillable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug'
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
        });
        static::updating(function (self $folder) {
            static::setSlug($folder);
            static::assertFieldIsUnique($folder->slug, $folder->id);
        });
    }

    // * METHODS

    /**
     * Set the slug.
     *
     * @param \Illuminate\Database\Eloquent\Model $folder
     *
     * @return void
     */
    private static function setSlug(Model $folder)
    {
        $folder->slug = Str::slug($folder->name);
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
     * @param \Illuminate\Database\Eloquent\Model $folder
     * @return void
     */
    private function setOrder(Model $folder): void
    {
        $lastFolder = Folder::select('order')->orderBy('order', 'DESC')->first();

        if ($lastFolder === null) {
            $folder->order = 1;
        } else {
            $folder->order = $lastFolder->order + 1;
        }
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
