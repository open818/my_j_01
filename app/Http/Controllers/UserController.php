<?php

namespace App\Http\Controllers;

use App\Helpers\File;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\User;
use App\Models\UserMessage;
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
        /*$panel = [
            'left' => [
                'width' => 3,
                'class' => 'home-no-padding',
            ],
            'center' => [
                'width' => 9,
            ],
        ];*/

        $companies = Auth::user()->companies();
        if(count($companies) > 0){
            if($companies[0]->status == 2){
                //待审核,获取管理员信息
                $admin = CompanyUser::where('company_id', $companies[0]->company_id)->where('isadmin','Y')->first()->user;
                return view('pages.user_relevancy_view',compact('companies','admin'));
            }else{
                return view('pages.user_relevancy_view',compact('companies'));
            }
        }else{
            return view('pages.user_relevancy');
        }
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

            return redirect('/company/edit');
        }else{
            //公司存在，添加用户
            $company_user = new CompanyUser();
            $company_user->company_id = $company->id;
            $company_user->user_id = $user->id;
            $company_user->position = $position;
            $company_user->isadmin = 'N';
            $company_user->status = 2;
            $company_user->save();

            return redirect('/user/relevancy');
        }
    }

    /**
     *
     */
    public function getRelevancyUser(){
        $companies = Auth::user()->companies();
        $users = CompanyUser::with('user')->where('company_id', $companies[0]->company_id)->get();
        return view('pages.company_user',compact('users'));
    }

    public function applyRelevancyUser($id){
        $companies = Auth::user()->companies();
        if($companies[0]->isadmin == 'N'){
            return redirect()->back();
        }

        $user = CompanyUser::find($id);
        if(!$user || $user->status != 2 || $user->company_id != $companies[0]->company_id){
            return redirect()->back();
        }
        $user->status = 1;
        $user->save();
        return redirect()->back();
    }

    public function adminRelevancyUser($id){
        $companies = Auth::user()->companies();
        if($companies[0]->isadmin == 'N'){
            return redirect()->back();
        }

        $user = CompanyUser::find($id);
        if(!$user || $user->status != 1 || $user->company_id != $companies[0]->company_id){
            return redirect()->back();
        }
        $user->isadmin = 'Y';
        $user->save();

        $my = $companies[0];
        $my->isadmin = 'N';
        $my->save();

        return redirect('/');
    }

    public function deleteRelevancyUser($id){
        $companies = Auth::user()->companies();
        if($companies[0]->isadmin == 'N'){
            return redirect()->back();
        }

        $user = CompanyUser::find($id);
        if(!$user || $user->isadmin == 'Y' || $user->company_id != $companies[0]->company_id){
            return redirect()->back();
        }
        $user->delete();
        return redirect()->back();
    }

    //添加用户留言
    public function addUserMessage (Request $request){
        if(!empty($request->input('content'))){
            $message = new UserMessage();
            $message->from_id = Auth::user()->id;
            $message->to_id = $request->input('to');
            $message->content = $request->input('content');

            $message->save();
        }
        return redirect()->back();
    }

    //添加用户留言
    public function showUserMessage (Request $request){
        return view('pages.user_message');
    }

    //
    public function ajax_getUserMessage ($lastid = 0){
        $page_size = 2;

        $query = UserMessage::with('from_user')->where('to_id', Auth::user()->id);
        if($lastid > 0){
            $query->where('id', '<', $lastid);
        }
        $rs = $query->orderby('id', 'desc')->take($page_size)->get();
        if(count($rs) == 0){
            return response()->json(['count'=>0]);
        }

        $view = view('partials.usermessage_item', ['data'=>$rs]);
        foreach ($rs as $message){
            $message->isread = 'Y';
            $message->save();
        }
        return response()->json(['count'=>count($rs), 'html'=> (string)$view, 'lastid'=>(string)($rs[count($rs)-1]->id)]);
    }
}
