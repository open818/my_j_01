<?php

namespace App\Http\Controllers;

use App\Helpers\File;
use App\Models\Brand;
use App\Models\BusinessCircle;
use App\Models\Category;
use App\Models\Company;
use App\Models\CompanyDynamic;
use App\Models\CompanyUser;
use App\Models\UpdateFile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Auth;
use Illuminate\Support\Facades\Session;
use \Validator;

class CompanyController extends Controller
{
    private $page_size = 2;

    public function __construct()
    {

    }

    public function edit(Request $request)
    {
        $company = Auth::user()->company;
        if(empty($company)){
            abort(404, '数据错误！');
        }

        if($company->isadmin != 'Y'){
            abort(404, '非法操作！');
        }

        if(empty($request->session()->getOldInput())){
            $company = Company::findOrFail($company->id)->toArray();
            if(!empty($company['business_address'])){
                $strarr = explode(" ", $company['business_address']);
                $company['province'] = $strarr[0];
                $company['city'] = $strarr[1];
                if(!empty($company['url'])){
                    $company['url'] = substr($company['url'], 7);
                }
            }

            $request->query->add($company);
            $request->flash();
        }

        $circle = BusinessCircle::all();


        return view('pages.company_profile', compact('circle'));
    }

    public function update(Request $request){
        if($request->has('url')){
            $request->merge(['url'=>'http://'.$request->input('url')]);
        }
        $v = Validator::make($request->all(), [
            'profile' => 'max:2000',
            'address_details'  => 'max:200',
        ],[
            'profile.max' => '公司描述过长',
            'address_details.max' => '详细地址过长',
        ]);

        if ($v->fails()) {
            $this->throwValidationException(
                $request, $v
            );
        }

        $id = $request->input('id');
        $company = Auth::user()->company;
        if(empty($company) || $company->isadmin != 'Y' || $company->id != $id){
            abort(404, '非法操作！');
        }

        $company = Company::findOrFail($company->id);
        
        //user update
        $company->business_address = $request->input('province').' '.$request->input('city');
        $company->address_details = $request->input('address_details');
        $company->business_circle_id = $request->input('business_circle_id');
        $company->profile = $request->input('profile');

        $company->save();

        return redirect('/')->with([
            'alert_message' => "提交成功！",
        ]);
    }





    /**
     * 企业展示
     * @param $id
     * @param int $tab
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id, $tab=1){
        $panel = [
            'left' => [
                'width' => 4,
                'class' => 'home-no-padding',
            ],

            'center' => [
                'width' => 8,
            ],
        ];

        if($tab == 1){
            $company = Company::with(['employees' => function($query){
                $query->where('status', 1);
            }])->find($id);

            if(!empty($company->business_brands)){
                $company->business_brands = Brand::whereRaw('id in ('.$company->business_brands.')')->get();
            }

            if(!empty($company->business_categories)){
                $company->business_categories = Category::whereRaw('id in ('.$company->business_categories.')')->get();
            }

            return view('pages.company_show', compact('panel','company','tab'));
        }elseif($tab == 2){
            $company = Company::find($id);
            return view('pages.company_show', compact('panel','company', 'tab'));
        }

    }
}
