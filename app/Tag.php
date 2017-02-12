<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['title'];

    public function possessions()
    {
      return $this->belongsToMany(Possession::class);
    }
}
