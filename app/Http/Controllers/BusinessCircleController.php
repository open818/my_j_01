<?php

namespace App\Http\Controllers;

use App\Models\BusinessCircle;

class BusinessCircleController extends Controller
{
    /**
     * 根据城市获取商圈
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajax_getBydist($province='', $city='', $district='')
    {
        $rs = array();
        if(empty($province)){
            $rs = BusinessCircle::all();
        }else{
            $address = $province;
            if(!empty($city)){
                $address = $address.' '.$city;
            }

            if(!empty($district)){
                $address = $address.' '.$district;
            }
            $rs = BusinessCircle::where('address', $address)->get();
        }

        return response()->json($rs);
    }
}
