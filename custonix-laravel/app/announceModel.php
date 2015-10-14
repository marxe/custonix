<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class announceModel extends Model
{
    protected $table = 'announcement';
    protected $primaryKey = 'announcementid';
    protected $fillable = ['subject', 'announce', 'user_userid'];
    public $timestamps = false;
}
