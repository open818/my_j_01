<?php

namespace App\Models;

class Company extends BaseModel
{
    protected $table = 'company';

    /**
     * 获取企业用户列表
     */
    public function employees()
    {
        return $this->hasMany('App\Models\CompanyUser');
    }

    public function circle(){
        return $this->belongsTo('App\Models\BusinessCircle','business_circle_id','id');
    }
}
