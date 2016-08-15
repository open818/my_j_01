<?php

namespace App\Helpers;

use App\Models\BusinessCircle;

class BusinessCircleHelper
{
    public static function select($returnArray = false)
    {
        $circle = BusinessCircle::all()->toArray();
        return $returnArray ? $circle : json_encode($circle);
    }
}
