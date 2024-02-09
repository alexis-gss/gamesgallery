<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer                         $id           Id.
 * @property integer                         $rank         Rank of the game.
 * @property \App\Models\Game                $game_id      Game associated.
 * @property-read \Illuminate\Support\Carbon $created_at   Created date.
 * @property-read \Illuminate\Support\Carbon $updated_at   Updated date.
 *
 * @method static void booted()            Perform any actions required after the model boots.
 * @method static void setRank(self $rank) Set model's rank after the last element of the list.
 *
 * @property-read \App\Models\Game $game Get the Game that owns the Picture (relationship).
 */
class Rank extends Model
{
    use HasFactory;

    /**
     * The attributes that are fillable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'game_id',
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (self $rank) {
            self::setRank($rank);
        });
    }

    // * METHODS

    /**
     * Set model's rank after the last element of the list.
     *
     * @param self $rank
     * @return void
     */
    private static function setRank(self $rank): void
    {
        $rank->rank = \intval(self::query()->max('rank')) + 1;
    }

    // * RELATIONSHIPS

    /**
     * Get the Game that owns the Picture (relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
