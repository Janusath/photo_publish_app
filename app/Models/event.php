<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    use HasFactory;
    protected $fillable = [
        'cate_id',
        'title',
        'thumbnail_image',
        'date',

    ];

}
