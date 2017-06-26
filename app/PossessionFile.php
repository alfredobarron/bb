<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class PossessionFile extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'possession_files';
    protected $fillable = ['basename', 'extension', 'possession_id'];
    protected $appends = ['url', 'urlThumb'];

    public function possession()
    {
        return $this->belongsToMany(Possession::class);
    }

    public function getUrlAttribute()
    {
        return Storage::url('files/'.$this->possession_id.'/'.$this->basename);
    }

    public function getUrlThumbAttribute()
    {
        return Storage::url('files/'.$this->possession_id.'/thumb_'.$this->basename);
    }
}
