<?php

namespace App\Models;

use App\Enums\Role;
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
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        static::creating(function (User $user) {
            if (Hash::needsRehash($user->password)) {
                $user->password = Hash::make($user->password);
            }
        });

        static::updating(function (User $user) {
            if (Hash::needsRehash($user->password)) {
                $user->password = Hash::make($user->password);
            }
        });
        parent::boot();
    }
}
