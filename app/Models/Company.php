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
     * 获取企业代理的品牌
     */
    public function brands()
    {
        return $this->belongsToMany('App\Models\Brand');
    }

    /**
     * 获取企业经营的类目
     */
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    /**
     * 获取企业经营的动态
     */
    public function dynamics()
    {
        return $this->hasMany('App\Models\CompanyDynamic');
    }
}
