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

    /**
     * 获取企业经营的动态
     */
    public function dynamics()
    {
        return $this->hasMany('App\Models\CompanyDynamic');
    }

    public function circle(){
        return $this->belongsTo('App\Models\BusinessCircle','business_circle_id','id');
    }
}
