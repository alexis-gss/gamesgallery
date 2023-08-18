<?php

namespace App\Models;

use App\Enums\Users\RoleEnum;
use App\Lib\Helpers\FileStorageHelper;
use App\Lib\Helpers\ToolboxHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Folder of games.
 *
 * @property integer                         $id            Id.
 * @property string                          $name          Name
 * @property string                          $slug          Slug of the name.
 * @property string                          $email         Email.
 * @property string                          $picture       Path of the account's picture.
 * @property string                          $picture_alt   Attribute alt of the picture.
 * @property string                          $picture_title Attribute title of the picture.
 * @property string                          $password      Password.
 * @property \App\Enums\Users\RoleEnum       $role          Role.
 * @property integer                         $order         Order of the name.
 * @property-read \Illuminate\Support\Carbon $created_at    Created date.
 * @property-read \Illuminate\Support\Carbon $updated_at    Updated date.
 *
 * @method protected static function booted()              Perform any actions required after the model boots.
 * @method private static function setSlug($folder)        Set model's slug.
 * @method private static function setImage($user)         Set model's account's picture.
 * @method private static function setOrder($folder)       Set model's order after the last element of the list.
 * @method private static function updatePassword($target) Update model's password.
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are fillable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'picture',
        'picture_alt',
        'picture_title',
        'password',
        'role',
    ];

    /**
     * Cast the property to an enum.
     *
     * @var array
     */
    protected $enumCasts = [
        'role' => RoleEnum::class
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
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (self $user) {
            static::setSlug($user);
            static::updatePassword($user);
            static::setOrder($user);
            static::setImage($user);
        });
        static::updating(function (self $user) {
            static::updatePassword($user);
            static::setImage($user);
        });
        static::updated(function (self $model) {
            FileStorageHelper::removeOldFile($model, 'picture');
        });
        static::deleted(function (self $model) {
            FileStorageHelper::removeFile($model, 'picture');
        });
    }

    // * METHODS

    /**
     * Set model's slug.
     *
     * @param \App\Models\User $user
     * @return void
     */
    private static function setSlug(User $user)
    {
        $user->slug = Str::slug($user->name);
    }

    /**
     * Set model's account's picture.
     *
     * @param \App\Models\User $user
     * @return void
     */
    private static function setImage(User $user)
    {
        $user->picture_alt   = "Default picture of " . $user->name . " account";
        $user->picture_title = "User's picture of " . $user->name . " account";
        $user->picture       = FileStorageHelper::storeFile($user, $user->picture, true);
    }

    /**
     * Set model's order after the last element of the list.
     *
     * @param \App\Models\User $user
     * @return void
     */
    private static function setOrder(User $user): void
    {
        $user->order = \intval(self::query()->max('order')) + 1;
    }

    /**
     * Update model's password.
     *
     * @param User $target
     * @return void
     */
    private static function updatePassword(User $target): void
    {
        if ($target->password != null and Hash::needsRehash($target->password)) {
            $target->password = Hash::make($target->password);
        } else {
            $target->password = $target->getOriginal('password');
        }
    }
}
