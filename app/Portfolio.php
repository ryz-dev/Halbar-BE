<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $table = 'pages_work';
    protected $fillable = ['sort', 'title', 'content', 'tag', 'image', 'link'];
}
