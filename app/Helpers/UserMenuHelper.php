<?php

namespace App\Helpers;

class UserMenuHelper
{
    public static function menu($returnArray = false)
    {
        $menu = [
            ['route' => '/',            'text' => '首页',              'icon' => 'glyphicon glyphicon-dashboard'],
            ['route' => '/user/profile',    'text' => '个人设置',        'icon' => 'glyphicon glyphicon-cog'],
            ['route' => '/user/relevancy', 'text' => '企业关联', 'icon' => 'glyphicon glyphicon-tasks'],
        ];

        if (count(\Auth::user()->able_companies()) > 0) {
            $menu = array_merge($menu, [
                ['route' => '/company/dynamic/add', 'text' => '发布商机', 'icon' => 'glyphicon glyphicon-cog'],
            ]);
        }

        if (\Auth::user()->isAdmin()) {
            $menu = array_merge($menu, [
                ['route' => '/company/edit', 'text' => '企业设置', 'icon' => 'glyphicon glyphicon-cog', 'divider' => 1],
                ['route' => '/company/relevancy/user', 'text' => '企业员工', 'icon' => 'glyphicon glyphicon-cog', 'divider' => 1],
            ]);
        }
        //dd($menu);
        return $returnArray ? $menu : json_encode($menu);
    }
}
