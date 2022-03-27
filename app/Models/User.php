<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

/**
 * @OA\Schema (
 *  required = {"password", "username", "email"},
 *  @OA\Xml (name="User"),
 *  @OA\Property(property = "id", type = "integer", readOnly = true),
 *  @OA\Property(property = "username", type = "string"),
 *  @OA\Property(property = "email", type = "string"),
 *  @OA\Property(property = "password", type = "string"),
 *  @OA\Property(property = "clan", type = "string"),
 *  @OA\Property(property = "last_ip",type = "string"),
 *  @OA\Property(property = "device_id", type = "integer"),
 *  @OA\Property(property = "standoff_id", type = "integer")
 * )
 */

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'email',
        'clan',
        'last_ip',
        'device_id',
        'standoff_id',
        'password',
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

    public function device(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    // Register avatar mediacollection, it can use only one file in the collection
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(64)
            ->height(64)
            ->performOnCollections('avatar');
    }
}
