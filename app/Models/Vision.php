<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vision extends Model
{
    protected $fillable = ['title','content','img_path','upload_time','thumbnail'];

    protected $table = 'vision';

    public $timestamps = false;
}
