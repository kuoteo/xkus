<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title','content','img_path','upload_time'];

    protected $table = 'product';

    public $timestamps = false;
}
