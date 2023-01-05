<?php

namespace App\Models;

use App\Enums\Role;
use App\Lib\Helpers\ToolboxHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
            static::setAttributeAlt($user);
            static::updatePassword($user);
            static::setOrder($user);
        });
        static::updating(function (self $user) {
            static::assertFieldsAreUnique($user, $user->id);
            static::setAttributeAlt($user);
            static::updatePassword($user);
        });
    }

    // * METHODS

    /**
     * Set the slug.
     *
     * @param \Illuminate\Database\Eloquent\Model $user
     *
     * @return void
     */
    private static function setSlug(Model $user)
    {
        $user->slug = Str::slug($user->name);
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
     * @param mixed        $model
     * @param integer|null $id
     * @return void
     * @throws \Illuminate\Validation\ValidationException If field already exists.
     */
    private static function assertFieldsAreUnique($model, ?int $id = null)
    {
        $table = (new self())->getTable();
        ToolboxHelper::assertFieldIsUnique($table, 'slug', $model->slug, $id);
        ToolboxHelper::assertFieldIsUnique($table, 'email', $model->email, $id);
    }

    /**
     * Set 'alt' attribute for the profile picture.
     *
     * @param \Illuminate\Database\Eloquent\Model $user
     * @return void
     */
    public function setAttributeAlt(Model $user): void
    {
        $user->picture_alt = "Picture for the " . $user->name . " account";
    }

    /**
     * Set order after the last element of the list.
     *
     * @param \Illuminate\Database\Eloquent\Model $user
     * @return void
     */
    public function setOrder(Model $user): void
    {
        $user->order = \intval(self::query()->max('order')) + 1;
    }
}
