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
            //1、品牌检索
            $match_brands = Brand::Where('name','like',$search_key)->get();

            //2、分类检索
            $match_categories = Category::Where('status', 1)->Where('name','like',$search_key)->get();

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

            if($match_brands){
                foreach ($match_brands as $brand){
                    $query->orWhere('business_brands', 'like', ','.$brand->id.',');
                }
            }

            if($match_categories){
                foreach ($match_categories as $category){
                    $query->orWhere('business_categories', 'like', ','.$category->id.',');
                }
            }

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

        $rs = $this->getSearchQuery($search_key)->get(['business_address','business_brands','business_categories']);
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

            if(!empty($company->business_brands)){
                $temp = array_merge($brands_ids, explode(",", $company->business_brands));
                $temp = array_flip($temp);
                $brands_ids = array_keys($temp);
            }

            if(!empty($company->business_categories)){
                $temp = array_merge($category_ids, explode(",", $company->business_categories));
                $temp = array_flip($temp);
                $category_ids = array_keys($temp);
            }
        }

        $brands = array();
        if(!empty($brands_ids)){
            $brands = Brand::whereIn('id',$brands_ids)->get(['id','name']);
        }

        $categories = array();
        if(!empty($category_ids)){
            $p_ids = Category::whereIn('id',$category_ids)->lists('p_id');
            $categories = Category::whereIn('id',$p_ids)->get(['id','name']);
        }

        return view('pages.search', compact('search_key','panel','brands','categories','province_s'));
    }

    public function ajax_search($search_key, $page = 1)
    {
        $category_id = request()->input('id1', 0);
        $brand_id = request()->input('id2', 0);
        $area = request()->input('area', '');
        //供应商表
        $query = $this->getSearchQuery($search_key);
        if($brand_id > 0){
            $query->whereRaw("CONCAT(',',business_brands,',') like CONCAT('%',".$brand_id.",'%')");
        }

        if($category_id > 0){
            $query->whereRaw("CONCAT(',',business_categories,',') like CONCAT('%',".$category_id.",'%')");
        }

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

            if(!empty($company->business_brands)){
                $company->business_brands = Brand::whereRaw('id in ('.$dynamic->company->business_brands.')')->get();
            }

            if(!empty($company->business_categories)){
                $company->business_categories = Category::whereRaw('id in ('.$dynamic->company->business_categories.')')->get();
            }
        }

        $view = view('partials.search_item', ['data'=>$companies]);
        return response()->json(['count'=>count($companies), 'html'=> (string)$view, 'lastid'=>$page+1]);
    }
}
