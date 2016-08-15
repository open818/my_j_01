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

        if (\Auth::user()->isAdmin()) {
            $menu = array_merge($menu, [
                ['route' => '/company/edit', 'text' => '企业设置', 'icon' => 'glyphicon glyphicon-cog', 'divider' => 1],
            ]);
        }
        //dd($menu);
        return $returnArray ? $menu : json_encode($menu);
    }
}
