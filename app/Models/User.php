<?php

namespace App\Models;

use App\Enums\Role;
use App\Lib\Utils;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * Cast the property to an enum.
     *
     * @var array
     */
    protected $enumCasts = [
        'role' => Role::class
    ];

    /**
     * The attributes that are fillable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'picture',
        'picture_alt',
        'password',
        'role',
        'order'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        static::creating(function (User $user) {
            $user->updateImage($user);
            $user->password = $user->updatePassword($user->password);
        });

        static::updating(function (User $user) {
            $user->updateImage($user);
            $user->password = $user->updatePassword($user->password);
        });
        parent::boot();
    }

    /**
     * Update images.
     *
     * @param User $target
     * @return void
     */
    private static function updateImage(User $target): void
    {
        if ($target->picture) {
            $target->picture = Utils::storeImage($target, $target->picture);
        }
    }

    /**
     * Update password.
     *
     * @param string $target
     * @return string
     */
    private static function updatePassword(string $target): string
    {
        if (Hash::needsRehash($target)) {
            return Hash::make($target);
        } else {
            return $target;
        }
    }
}
