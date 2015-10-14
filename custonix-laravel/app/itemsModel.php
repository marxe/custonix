<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class itemsModel extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'itemid';
    protected $fillable = ['itemname','qty', 'picture', 'comment', 'datetofinish', 'user_userid', 'category_categoryid'];
}
