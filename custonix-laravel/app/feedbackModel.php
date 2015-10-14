<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class feedbackModel extends Model
{
  protected $table = 'feedback';
  protected $primaryKey = 'feedbackid';
  protected $fillable = ['feedbackmessage', 'rating', 'user_userid'];
  public $timestamps = false;
}
