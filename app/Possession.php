<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Possession extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'description', 'favorite', 'user_id'];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function tags()
    {
      return $this->belongsToMany(Tag::class);
    }

    public function share()
    {
      return $this->belongsToMany(User::class, 'possession_share');
    }

}
