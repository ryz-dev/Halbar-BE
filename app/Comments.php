<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comments extends Model
{
    protected $table = 'comments';
    protected $fillable = ['id_user', 'id_parent', 'id_posts', 'comment'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
