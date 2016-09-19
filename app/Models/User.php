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

    protected $appends = ['company'];

    public function getCompanyAttribute()
    {
        $company = '';

        $c_u = CompanyUser::with('company')->where('user_id', $this->attributes['id'])->first();
        if($c_u){
            $company = $c_u->company;
            $company->position = $c_u->position;
            $company->territory = $c_u->territory;
            $company->isadmin = $c_u->isadmin;
            $company->status = $c_u->status;
            $company->company_user_id = $c_u->id;
        }

        return $this->attributes['company'] = $company ;
    }
}
