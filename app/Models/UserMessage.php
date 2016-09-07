<?php

namespace App\Models;

class UserMessage extends BaseModel
{
    protected $table = 'user_message';

    public function from_user()
    {
        return $this->belongsTo('App\Models\User','from_id','id');
    }

    public function to_user()
    {
        return $this->belongsTo('App\Models\User','to_id','id');
    }
}
