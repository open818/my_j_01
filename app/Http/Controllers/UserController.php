<?php

namespace App\Http\Controllers;

use App\Helpers\File;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\User;
use Illuminate\Http\Request;
use \Auth;
use \Validator;

class UserController extends Controller
{
    public function __construct()
    {

    }

    public function profile(Request $request)
    {
        $user = User::findOrFail(Auth::id())->toArray();
        $request->query->add($user);
        $request->flash();
        return view('pages.user_profile');
    }

    public function saveProfile(Request $request){
        $user = Auth::user();
        $v = Validator::make($request->all(), [
            'name' => 'required|max:10',
            'pic'  => 'image',
            'email'  => 'email',
            'phone' => 'regex:/^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/',
        ],[
            'name.required' => '真实姓名必填',
            'name.max' => '真实姓名过长',
            'pic.image' => '必须是图片格式2',
            'email.email' => '电子邮箱格式不对',
            'phone.regex' => '座机格式不正确',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        //user update
        $file = File::section('profile_img')->upload($request->file('pic'));
        $user->fill($request->all());
        $user->pic_url = $file;
        $user->save();

        return redirect()->back();
    }

    public function relevancy_company(){
        $panel = [
            'left' => [
                'width' => 3,
                'class' => 'home-no-padding',
            ],
            'center' => [
                'width' => 9,
            ],
        ];

        return view('pages.user_relevancy',compact('panel'));
    }

    public function saveRelevancy(Request $request){
        $user = Auth::user();

        //获取用户关联的公司
        $cn = CompanyUser::where('user_id', $user->id)->count();
        if($cn > 0){
            return redirect()->back()->withErrors(['company_name'=>'一个用户只能关联一个公司企业'])->withInput();
        }

        $v = Validator::make($request->all(), [
            'company_name' => 'required|max:200',
            'position'  => 'required|max:30',
        ],[
            'company_name.required' => '所属公司必填',
            'company_name.max' => '所属公司名过长',
            'position.required' => '所在职位必填',
            'position.max' => '所在职位名过长',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        $name = $request->input('company_name');
        $position = $request->input('position');

        $company = Company::with(['employees'=>function($query){
            $query->where('isadmin','Y');
        }])->where('name', $name)->first();

        if(empty($company)){
            //如果公司不存在
            //先添加公司
            $company = new Company();
            $company->name = $name;
            $company->save();

            //再添加公司用户
            $company_user = new CompanyUser();
            $company_user->company_id = $company->id;
            $company_user->user_id = $user->id;
            $company_user->position = $position;
            $company_user->isadmin = 'Y';
            $company_user->status = 1;
            $company_user->save();

            return '跳到维护企业界面';
        }else{
            //公司存在，添加用户
            $company_user = new CompanyUser();
            $company_user->company_id = $company->id;
            $company_user->user_id = $user->id;
            $company_user->position = $position;
            $company_user->isadmin = 'N';
            $company_user->status = 2;
            $company_user->save();

            return '跳到提示界面';
        }
    }
}