<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    //
    protected $fillable = [
        'from_user_id','to_user_id','stamp_id','message','image'
    ];
}
