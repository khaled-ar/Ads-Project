<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Files;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'email',
        'ip_address',
        'image',
        'role',
        'account_status',
        'notes',
        'fcm'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'image',
        'fcm'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = ['image_url'];

    /**
     * Route notifications for the FCM channel.
     */
    public function routeNotificationForFcm($notification = null): ?string
    {
        return $this->fcm;
    }

    public function getImageUrlAttribute() {
        return $this->image ? asset('Images') . "/{$this->id}/" . $this->image : null;
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            if(request('image')) {
                $user->image = Files::moveFile(request('image'), "Images");
                $user->save();
            }
        });
    }

    public function driver() {
        return $this->hasOne(Driver::class);
    }

    public function ads() {
        return $this->hasMany(Ad::class);
    }
}
