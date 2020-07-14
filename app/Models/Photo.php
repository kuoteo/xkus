<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['title','author','upload-time'
        ,'type','madia-path','tag','content','thumbnail'];

    protected $table = 'photo';

    public $timestamps = false;
}
