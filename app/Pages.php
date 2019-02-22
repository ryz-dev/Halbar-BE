<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pages extends Model
{
    protected $table = 'pages';
    protected $fillable = ['id_user', 'slug', 'title', 'content', 'image'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->hasMany(Category::class, 'id', 'category');
    }
}
