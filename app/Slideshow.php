<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    protected $table = 'slider';
    protected $fillable = ['sort', 'title', 'desc', 'image', 'link'];
}
