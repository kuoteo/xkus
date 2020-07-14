<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homepage extends Model
{
    protected $fillable = ['img_path','title','s_title','url','type'];

    protected $table = 'homepage';

    public $timestamps = false;
}
