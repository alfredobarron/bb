<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class PossessionFolder extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['title', 'description', 'possession_id'];

    public function possession()
    {
        return $this->belongsToMany(Possession::class);
    }
}
