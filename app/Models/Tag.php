<?php

namespace App\Models;

use App\Lib\Utils;
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
        'name'
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function (Tag $tag) {
            static::assertNameIsUnique($tag->name);
            $tag->slug = Str::slug($tag->name);
        });
        static::updating(function (Tag $tag) {
            static::assertNameIsUnique($tag->name, $tag->id);
            $tag->slug = Str::slug($tag->name);
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
        Utils::assertFieldIsUnique($table, 'slug', Str::slug($name), $id);
    }

    // * RELATIONSHIPS

    /**
     * MorphToMany games relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function games()
    {
        return $this->morphedByMany(Game::class, 'taggable');
    }
}
