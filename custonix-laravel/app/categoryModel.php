<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categoryModel extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'categoryid';
    protected $fillable = ['categoryname', 'categorydescription', 'imageicon'];
    public $timestamps = false;
}
