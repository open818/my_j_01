<?php

namespace App\Helpers;

use App\Models\Category;

class CategoryHelper
{
    public static function getAll()
    {
        return $category = Category::where('status', '1')->get();
    }
}
