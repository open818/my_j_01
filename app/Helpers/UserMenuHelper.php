<?php

namespace App\Helpers;

use App\Models\CompanyUser;
use App\Models\User;
use App\Models\UserMessage;
use \Auth;

class UserMenuHelper
{
    public static function menu($returnArray = false)
    {
        $user = Auth::user();

        //获取当前用户未读留言
        $cn = UserMessage::where('to_id', $user->id)->where('isread', 'N')->count();

        $menu = [
            ['route' => '/',            'text' => '首页',              'icon' => 'glyphicon glyphicon-dashboard'],
            ['route' => '/user/profile',    'text' => '个人设置',        'icon' => 'glyphicon glyphicon-cog'],
            ['route' => '/user/relevancy', 'text' => '企业关联', 'icon' => 'glyphicon glyphicon-tasks'],
            ['route' => '/user/message/show', 'text' => '留言信息', 'icon' => 'fa fa-comments', 'num'=>$cn],
        ];

        if (count(Auth::user()->able_companies()) > 0) {
            $menu = array_merge($menu, [
                ['route' => '/company/dynamic/add', 'text' => '发布商机', 'icon' => 'glyphicon glyphicon-cog'],
            ]);
        }

        if (Auth::user()->isAdmin()) {
            //获取待审核用户
            $company = CompanyUser::where('user_id', $user->id)->where('isadmin','Y')->first();
            $cn = CompanyUser::where('company_id', $company->id)->where('status', 2)->count();

            $menu = array_merge($menu, [
                ['route' => '/company/edit', 'text' => '企业设置', 'icon' => 'glyphicon glyphicon-cog', 'divider' => 1],
                ['route' => '/company/relevancy/user', 'text' => '企业员工', 'icon' => 'glyphicon glyphicon-cog', 'num' => $cn],
            ]);
        }
        //dd($menu);
        return $returnArray ? $menu : json_encode($menu);
    }
}
