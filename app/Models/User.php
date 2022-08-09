<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Laratrust\Traits\LaratrustPermissionTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    use SearchableTrait;
    use HasApiTokens, HasFactory, Notifiable;
    use LaratrustUserTrait;

    const User_PATH = 'images/users/';
    const User_Defualt = 'user.png';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = ['name','email','password',];

    protected $guarded = [];


    protected $searchable = [
        'columns'   => [
            'users.name'             => 10,
            'users.username'         => 10,
            'users.email'            => 10,
            'users.mobile'           => 10,
            'users.bio'              => 10,

        ],
    ];

    public function receivesBroadcastNotificationsOn()
    {
        return 'App.User.'.$this->id;
    }




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
        'email_verified_at' => 'datetime',
    ];



    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }


    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

    public function status()
    {
        return $this->status == '1' ? 'Active' : 'Inactive';
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permission()
    {
        return $this->belongsToMany(Permission::class, 'id', 'permission_id');
    }



}
