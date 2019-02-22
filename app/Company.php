<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    protected $table = 'company';
    protected $fillable = ['users_id', 'perusahan', 'bidang', 'telp','alamat','email'];
}
