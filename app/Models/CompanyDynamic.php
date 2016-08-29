<?php

namespace App\Models;

class CompanyDynamic extends BaseModel
{
    protected $table = 'company_dynamic';

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
