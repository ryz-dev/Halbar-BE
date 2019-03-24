<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';
    protected $fillable = [
        'informer_fullname',
        'informer_address',
        'informer_email',
        'informer_phone',
        'suspect_fullname',
        'suspect_department',
        'suspect_division',
        'read_status',
        'subject',
        'complaint'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
