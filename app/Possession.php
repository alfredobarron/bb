<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Possession extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'description', 'favorite', 'user_id', 'parent_id', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Possession::class,'parent_id');
    }

    public function files()
    {
        return $this->hasMany(PossessionFile::class);
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
