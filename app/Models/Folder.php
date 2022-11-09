<?php

namespace App\Models;

use App\Lib\Utils;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    /**
     * The attributes that are fillable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();

        static::updating(function (self $folder) {
            static::assertNameIsUnique($folder->name, $folder->id);
        });

        static::deleting(function (self $folder) {
            static::assertNameIsUnique($folder->name, $folder->id);
        });
    }

    // * METHODS

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
