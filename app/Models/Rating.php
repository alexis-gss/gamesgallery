<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer                         $id         Id.
 * @property string                          $uuid       IP of the user.
 * @property \App\Models\Picture             $picture_id Picture associated.
 * @property-read \Illuminate\Support\Carbon $created_at Created date.
 * @property-read \Illuminate\Support\Carbon $updated_at Updated date.
 *
 * @property-read \App\Models\Picture $picture Get the Picture that owns the Rating (belongs-to relationship).
 */
class Rating extends Model
{
    use HasFactory;

    /**
     * The attributes that are fillable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'picture_id',
    ];

    // * RELATIONSHIPS

    /**
     * Get the Picture that owns the Rating (belongs-to relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function picture(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Picture::class);
    }
}
