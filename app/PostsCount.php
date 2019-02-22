<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostsCount extends Model
{
    protected $table = 'posts_count';
    protected $fillable = ['posts', 'ip_address','user_agent'];
    public $timestamps = false;
}
