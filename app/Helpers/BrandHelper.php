<?php

namespace App\Helpers;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;

class BrandHelper
{
    public static function getAllBrand(){
        return Brand::all();
    }
}
