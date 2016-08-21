<?php

namespace App\Models;

class CompanyUser extends BaseModel
{
    protected $table = 'company_user';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
