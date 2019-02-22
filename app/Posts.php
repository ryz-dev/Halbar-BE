<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posts extends Model
{
    protected $table = 'posts';
    protected $fillable = ['id_user', 'slug', 'title', 'content', 'keyword', 'image', 'category', 'status', 'comment' ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function category()
    {
        return $this->hasMany(Category::class, 'id', 'category');
    }

    public function comment()
    {
        return $this->hasMany(Comments::class, 'id_posts', 'id');
    }

    public function count()
    {
        return $this->hasMany(PostsCount::class, 'posts', 'id');
    }
}
