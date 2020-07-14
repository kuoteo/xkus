<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['title','author','upload-time'
        ,'type','madia-path','tag','content','sort','url'];

    protected $table = 'video';

    public $timestamps = false;
}
