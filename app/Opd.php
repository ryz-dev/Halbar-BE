<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opd extends Model
{
    protected $table = 'opd';
    protected $fillable = [
        'id_user', 
        'title', 
        'slug', 
        'welcome_message', 
        'content', 
        'image',
        'link', 
        'team_id', 
        'category', 
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->hasMany(Category::class, 'id', 'category');
    }
    
}
