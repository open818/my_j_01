<?php

namespace App\Http\Controllers;

use App\Helpers\File;
use App\Models\BusinessCircle;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\User;
use Illuminate\Http\Request;
use \Auth;
use Illuminate\Support\Facades\Session;
use \Validator;

class CompanyController extends Controller
{
    public function __construct()
    {

    }

    public function edit(Request $request)
    {
        $companies = Auth::user()->companies();
        if(empty($companies) || count($companies) > 1 ){
            abort(404, '数据错误！');
        }

        if($companies[0]->isadmin != 'Y'){
            abort(404, '非法操作！');
        }

        if(empty($request->session()->getOldInput())){
            $company = Company::findOrFail($companies[0]->company_id)->toArray();
            if(!empty($company['business_address'])){
                $strarr = explode(" ", $company['business_address']);
                $company['province'] = $strarr[0];
                $company['city'] = $strarr[1];
                $company['district'] = $strarr[2];
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
            'tel'  => 'max:20',
            'fax'  => 'max:20',
            'email'  => 'email|max:50',
            'url' => 'url|max:50',
        ],[
            'profile.max' => '公司描述过长',
            'address_details.max' => '详细地址过长',
            'tel.max' => '电话长度过长',
            'fax.max' => '传真长度过长',
            'email.email' => '电子邮箱格式不对',
            'url.url' => '公司网址格式不正确',
            'url.max' => '公司网址长度过长',
        ]);

        if ($v->fails()) {
            $this->throwValidationException(
                $request, $v
            );
        }

        $id = $request->input('id');
        $companies = Auth::user()->companies();
        if(empty($companies) || count($companies) > 1 || $companies[0]->isadmin != 'Y' || $companies[0]->company_id != $id){
            abort(404, '非法操作！');
        }

        $company = Company::findOrFail($companies[0]->company_id);
        
        //user update
        $company->business_address = $request->input('province').' '.$request->input('city').' '.$request->input('district');
        $company->address_details = $request->input('address_details');
        $company->business_circle_id = $request->input('business_circle_id');
        $company->tel = $request->input('tel');
        $company->fax = $request->input('fax');
        $company->email = $request->input('email');
        $company->url = $request->input('url');
        $company->profile = $request->input('profile');
        $company->business_brands = empty($request->input('business_brand'))?null:implode(',',$request->input('business_brand'));
        $company->business_categories = $request->input('business_categories');
        $company->save();

        return redirect()->back();
    }
}