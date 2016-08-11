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
        return $this->hasMany('App\Model\CompanyUser');
    }

    /**
     * 获取企业代理的品牌
     */
    public function brands()
    {
        return $this->belongsToMany('App\Model\Brand');
    }

    /**
     * 获取企业经营的类目
     */
    public function categories()
    {
        return $this->belongsToMany('App\Model\Category');
    }

    /**
     * 获取企业经营的类目
     */
    public function dynamics()
    {
        return $this->hasMany('App\Model\CompanyDynamic');
    }
}
