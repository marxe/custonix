<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class requestModel extends Model
{
    protected $table = 'request';
    protected $primaryKey = 'bidid';
    protected $fillable = ['price','status', 'date_started', 'userid', 'progressbar', 'trackingnumber', 'category'];
}
