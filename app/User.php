<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'last_name', 'birthday', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'connections' => 'array'
    ];

    protected $appends = ['avatar_url'];

    public function possessions()
    {
      return $this->hasMany(Possession::class);
    }

    public function getAvatarUrlAttribute()
    {
        if (substr( $this->avatar, 0, 7 ) === "http://" || substr( $this->avatar, 0, 8 ) === "https://")
            return $this->avatar;

        return Storage::url('avatars/'. $this->id .'/'. $this->avatar);
    }

    public function emailChange()
    {
      return $this->hasOne(EmailChange::class);
    }
}
