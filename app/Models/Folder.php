<?php

namespace App\Models;

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
     * Get Games for the Range.
     *
     * @return array
     */
    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
