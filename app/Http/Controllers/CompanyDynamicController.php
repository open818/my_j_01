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

class CompanyDynamicController extends Controller
{
    private $page_size = 2;

    public function dynamic_add(){
        if(empty(Auth::user()->company)){
            return redirect('/user/relevancy')->with([
                'alert_message' => "请先关联企业！",
            ]);
        }

        if(Auth::user()->company->status==2 ){
            return redirect('/user/relevancy')->with([
                'alert_message' => "请先等关联企业管理员审核通过！",
            ]);
        }
        $categories = Category::where('status', 1)->get();
        return view('pages.company_dynamic_add', compact('categories'));
    }

    public function dynamic_create(Request $request){
        $v = Validator::make($request->all(), [
            'category_id' => 'required',
            'content'  => 'required|max:2000'
        ],[
            'category_id.required' => '必须选择类型',
            'content.required' => '内容不能为空',
            'content.max' => '内容长度过长',
        ]);

        if ($v->fails()) {
            $this->throwValidationException($request, $v);
        }

        $company = Auth::user()->company;
        if(empty($company)){
            abort(404, '非法操作！');
        }

        $dynamic = new CompanyDynamic();
        $dynamic->company_id = $company->id;
        $dynamic->category_id = $request->input('category_id');
        $dynamic->content = $request->input('content');
        $dynamic->attachments = $request->input('attachments');
        $dynamic->user_id = Auth::user()->id;
        $dynamic->user_name = Auth::user()->name;
        $dynamic->save();

        return redirect('/');
    }

    /**
     * 企业动态上传附件
     * @param Request $request
     * @return mixed|string
     */
    public function uploadAttachment(Request $request)
    {
        $name = File::section('dynamic_attachment')->upload($request->file('attachment'));
        return json_encode($name);
    }

    public function ajax_getByCompany($company_id, $lastTime = '')
    {
        if(empty($lastTime)){
            $lastTime = Carbon::now();
        }
        $rs = CompanyDynamic::where('company_id', $company_id)->where('created_at', '<', $lastTime)->orderby('created_at', 'desc')->take($this->page_size)->get();
        if(count($rs) == 0){
            return response()->json(['count'=>0]);
        }

        foreach($rs as &$dynamic){
            if(!empty($dynamic->attachments)){
                $attachments = UpdateFile::whereRaw('id in ('. $dynamic->attachments.')')->get();
                $dynamic->attachments = $attachments;
            }
        }
        //return view('partials.company_dynamic', ['data'=>$rs]);
        $view = view('partials.company_dynamic', ['data'=>$rs]);
        return response()->json(['count'=>count($rs), 'html'=> (string)$view, 'lastTime'=>(string)($rs[count($rs)-1]->created_at)]);
    }

    public function ajax_getIndexCompany($lastTime = ''){
        if(empty($lastTime)){
            $lastTime = Carbon::now();
        }

        $rs = CompanyDynamic::with('company')->where(function($query){
            $cate_id = request()->input('id1', 0);
            if($cate_id>0){
                $query->where('category_id', $cate_id);
            }
        })->where('created_at', '<', $lastTime)->orderby('created_at', 'desc')->take($this->page_size)->get();

        if(count($rs) == 0){
            return response()->json(['count'=>0]);
        }

        foreach($rs as &$dynamic){
            if(!empty($dynamic->attachments)){
                $attachments = UpdateFile::whereRaw('id in ('. $dynamic->attachments.')')->get();
                $dynamic->attachments = $attachments;
            }
        }
        //return view('partials.dynamic', ['data'=>$rs]);
        $view = view('partials.dynamic', ['data'=>$rs]);
        return response()->json(['count'=>count($rs), 'html'=> (string)$view, 'lastTime'=>(string)($rs[count($rs)-1]->created_at)]);
    }
}
