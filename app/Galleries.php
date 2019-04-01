<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Galleries extends Model
{
    protected $table = 'media_album';

    public function image(){
        return $this->hasMany('App\Images', 'id_albums','id');
    }
}
