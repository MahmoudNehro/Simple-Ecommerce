<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'is_admin' => 'boolean'
    ];
    public function getNotifications(): ?DatabaseNotificationCollection
    {
        if (Cache::has('unread_notifications_' . auth()->id())) {
            $notifications = Cache::get('unread_notifications_' . auth()->id());
        } else {
            $notifications = $this->unreadNotifications()->latest()->take(10)->get();
            Cache::put('unread_notifications_' . auth()->id(), $notifications, 60);
        }
        return  $notifications;
    }
}
