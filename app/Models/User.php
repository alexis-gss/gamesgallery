<?php

namespace App\Models;

use App\Enums\Role;
use App\Lib\Helpers\FileStorageHelper;
use App\Lib\Helpers\ToolboxHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $email
 * @property string $picture
 * @property string $picture_alt
 * @property string $picture_title
 * @property string $password
 * @property integer $role
 * @property integer $order
 */
class User extends Authenticatable
{
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
        'picture_title',
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
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (self $user) {
            static::setSlug($user);
            static::assertFieldsAreUnique($user);
            static::updatePassword($user);
            static::setOrder($user);
            static::setImage($user);
        });
        static::updating(function (self $user) {
            static::assertFieldsAreUnique($user, $user->id);
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
     * Set the slug.
     *
     * @param \App\Models\User $user
     * @return void
     */
    private static function setSlug(User $user)
    {
        $user->slug = Str::slug($user->name);
    }

    /**
     * Set the image.
     *
     * @param \App\Models\User $user
     * @return void
     */
    private static function setImage(User $user)
    {
        $user->picture = FileStorageHelper::storeFile($user, $user->picture, true);
    }

    /**
     * Update password.
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

    /**
     * Asserts using validation that the fields are unique.
     *
     * @param \App\Models\User $model
     * @param integer|null     $id
     * @return void
     * @throws \Illuminate\Validation\ValidationException If field already exists.
     */
    private static function assertFieldsAreUnique(User $model, ?int $id = null)
    {
        $table = (new self())->getTable();
        ToolboxHelper::assertFieldIsUnique($table, 'slug', $model->slug, $id);
        ToolboxHelper::assertFieldIsUnique($table, 'email', $model->email, $id);
    }

    /**
     * Set order after the last element of the list.
     *
     * @param \App\Models\User $user
     * @return void
     */
    private static function setOrder(User $user): void
    {
        $user->order = \intval(self::query()->max('order')) + 1;
    }
}
