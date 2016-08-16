<?php

namespace App\Helpers;

use App\Models\Category;

class CategoryHelper
{
    public static function getAll()
    {
        return Category::where('status', '1')->get();
    }

    public static function getCategory($p_id=0){
        return Category::where('status', '1')->where('p_id', $p_id)->orderBy('seqno')->get();
    }
}
