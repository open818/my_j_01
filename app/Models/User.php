<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $table = 'user';

    /**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * 获取用户企业列表
     */
    public function companies()
    {
        return CompanyUser::where('user_id', $this->attributes['id'])->get();
    }

    public function isAdmin()
    {
        $companies = CompanyUser::where('user_id', $this->attributes['id'])->get();
        if(empty($companies)){
            return false;
        }

        foreach($companies as $company){
            if($company->status != 0 && $company->isadmin == 'Y'){
                return true;
            }
        }
        return false;
    }
}
