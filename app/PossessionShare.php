<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PossessionShare extends Model
{

    protected $table = 'possession_share';

    protected $fillable = ['possession_id', 'user_id'];

}
