<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Possession extends Model
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions' => 'array'
    ];

    protected $fillable = ['title', 'description', 'permissions', 'user_id'];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function tags()
    {
      return $this->belongsToMany(Tag::class);
    }

}
