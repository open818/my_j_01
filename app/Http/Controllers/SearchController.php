<?php

namespace App\Http\Controllers;

use App\Helpers\File;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Company;
use App\Models\CompanyDynamic;
use App\Models\CompanyUser;
use App\Models\UpdateFile;
use App\Models\User;
use Illuminate\Http\Request;
use \Auth;
use \Validator;

class SearchController extends Controller
{
    private $page_size = 2;

    public function __construct()
    {

    }

    private function getSearchQuery($search_key){
        $search_key = '%'.$search_key.'%';

        //供应商表
        return Company::where('status', 1)->Where(function($query) use($search_key){
            //3、联系人
            $match_companyuser = CompanyUser::where('status',1)->whereHas('user', function($query) use($search_key){
                $query->where('name','like',$search_key)->orWhere('mobile','like',$search_key);
            })->get();

            //公司名称
            $query->orWhere('name','like',$search_key)
                //公司简介
                ->orWhere('profile','like',$search_key)
                //公司地址
                ->orWhere('business_address','like',$search_key)
                //公司详细地址
                ->orWhere('address_details','like',$search_key);

            if($match_companyuser){
                foreach ($match_companyuser as $companyuser){
                    $query->orWhere('id', $companyuser->company_id);
                }
            }
        });
    }

    public function search($search_key){
        $panel = [
            'center' => [
                'width' => 8,
            ],
            'right' => [
                'width' => 3,
                'class' => 'home-no-padding',
            ],
        ];

        $rs = $this->getSearchQuery($search_key)->get(['business_address']);
        $brands_ids = array();
        $category_ids = array();
        $province_s = array();
        foreach ($rs as $company){
            if(!empty($company->business_address)){
                $province = explode(" ",$company->business_address)[0];
                if(!array_key_exists($province, $province_s)){
                    $province_s[$province] = $province;
                }
            }
        }

        return view('pages.search', compact('search_key','panel','province_s'));
    }

    public function ajax_search($search_key, $page = 1)
    {
        $area = request()->input('area', '');
        //供应商表
        $query = $this->getSearchQuery($search_key);

        if(!empty($area)){
            $query->where("business_address","like", $area.'%');
        }

        $companies = $query->orderBy('sort_score', 'desc')->take($this->page_size)->skip($this->page_size*$page)->get();

        if(count($companies) == 0){
            return response()->json(['count'=>0]);
        }

        foreach($companies as &$company){
            $max_id = CompanyDynamic::where('company_id', $company->id)->max('id');
            if($max_id > 0){
                $dynamic = CompanyDynamic::find($max_id);
                if(!empty($dynamic->attachments)){
                    $attachments = UpdateFile::whereRaw('id in ('. $dynamic->attachments.')')->get();
                    $dynamic->attachments = $attachments;
                }

                $company->dynamic = $dynamic;
            }
        }

        $view = view('partials.search_item', ['data'=>$companies]);
        return response()->json(['count'=>count($companies), 'html'=> (string)$view, 'lastid'=>$page+1]);
    }
}
