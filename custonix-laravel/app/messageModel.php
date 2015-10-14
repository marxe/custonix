<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class messageModel extends Model
{
  protected $table = 'message';
  protected $primaryKey = 'messageid';
  protected $fillable = ['subject','contain', 'item_itemid', 'user_userid'];
}
