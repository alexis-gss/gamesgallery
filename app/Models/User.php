<?php

namespace App\Models;

use App\Enums\Users\RoleEnum;
use App\Lib\Helpers\FileStorageHelper;
use App\Traits\Models\ActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

/**
 * Folder of games.
 *
 * @property integer                         $id            Id.
 * @property string                          $first_name    Firstname.
 * @property string                          $last_name     Lastname.
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
 * @method protected static function booted()                    Perform any actions required after the model boots.
 * @method private static function updatePublishedStatus($model) Check if the authenticable user can update the
 * published status.
 * @method private static function setImage($user)               Set model's account's picture.
 * @method private static function setOrder($folder)             Set model's order after the last element of the list.
 * @method private static function updatePassword($target)       Update model's password.
 *
 * @property-read \App\Models\ActivityLog $activityLogs Activities logs One-to-many relationship.
 */
class User extends Authenticatable
{
    use ActivityLog;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are fillable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'picture',
        'picture_alt',
        'picture_title',
        'password',
        'role',
        'published',
        'published_at',
        'order',
    ];

    /**
     * Cast the property to an enum.
     *
     * @var array
     */
    protected $casts = [
        'role'              => RoleEnum::class,
        'email_verified_at' => 'datetime',
        'published'         => 'boolean',
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
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (self $model) {
            static::updatePassword($model);
            static::setOrder($model);
            static::setImage($model);
            static::checkElevationPrivileges($model);
        });
        static::updating(function (self $model) {
            static::updatePassword($model);
            static::setImage($model);
            static::updatePublishedStatus($model);
            static::checkElevationPrivileges($model);
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
     * Check if the authenticable user can update the published status.
     *
     * @param self $model
     * @return void
     */
    private static function updatePublishedStatus(self $model)
    {
        if (optional(auth('backend')->user())->getKey() === $model->getKey()) {
            \validator(
                ['published' => $model->published],
                ['published' => 'required|boolean|accepted'],
                ['published.accepted' => trans('Vous ne pouvez pas déactiver votre propre compte')],
            )->validate();
        }
    }

    /**
     * Prevent user elevation privileges.
     *
     * @param self $model
     * @return void
     */
    private static function checkElevationPrivileges(self $model)
    {
        throw_if(
            auth('backend')->user() and auth('backend')->user()->role->value() > $model->role->value(),
            AuthorizationException::class
        );
    }

    /**
     * Set model's account's picture.
     *
     * @param self $model
     * @return void
     */
    private static function setImage(self $model)
    {
        $model->picture_alt   = "Default picture of " . $model->first_name . " " . $model->last_name . " account";
        $model->picture_title = "User's picture of " . $model->first_name . " " . $model->last_name . " account";
        $model->picture       = FileStorageHelper::storeFile($model, $model->picture, true);
    }

    /**
     * Set model's order after the last element of the list.
     *
     * @param self $model
     * @return void
     */
    private static function setOrder(self $model): void
    {
        $model->order = \intval(self::query()->max('order')) + 1;
    }

    /**
     * Update model's password.
     *
     * @param self $model
     * @return void
     */
    private static function updatePassword(self $model): void
    {
        if ($model->password != null and Hash::needsRehash($model->password)) {
            $model->password = Hash::make($model->password);
        } else {
            $model->password = $model->getOriginal('password');
        }
    }

    // * RELATIONS

    /**
     * Activities logs One-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
