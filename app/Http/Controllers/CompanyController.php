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
        $company->business_address = $request->input('province').' '.$request->input('city');
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

    public function dynamic_add(){
        return view('pages.company_dynamic_add');
    }

    public function dynamic_create(Request $request){
        $v = Validator::make($request->all(), [
            'type' => 'required|max:1|in:1,2',
            'exp_date'  => 'date|date_format:Y-m-d',
            'content'  => 'required|max:2000'
        ],[
            'type.required' => '必须选择类型',
            'type.max' => '非法操作',
            'type.in' => '非法操作',
            'exp_date.date' => '失效日期不对',
            'exp_date.date_format' => '失效日期不对',
            'content.required' => '内容不能为空',
            'content.max' => '内容长度过长',
        ]);

        if ($v->fails()) {
            $this->throwValidationException($request, $v);
        }

        $companies = Auth::user()->companies();
        if(empty($companies) || count($companies) > 1){
            abort(404, '非法操作！');
        }

        $dynamic = new CompanyDynamic();

        //user update
        $dynamic->company_id = $companies[0]->company_id;
        $dynamic->type = $request->input('type');
        $dynamic->content = $request->input('content');
        $dynamic->attachments = $request->input('attachments');
        if(!empty($request->input('exp_date'))){
            $dynamic->exp_date = $request->input('exp_date');
        }
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

    public function ajax_getIndexCompany($lastTime = ''){
        if(empty($lastTime)){
            $lastTime = Carbon::now();
        }
        $rs = CompanyDynamic::with('company')->where('created_at', '<', $lastTime)->orderby('created_at', 'desc')->take($this->page_size)->get();

        if(count($rs) == 0){
            return response()->json(['count'=>0]);
        }

        foreach($rs as &$dynamic){
            if(!empty($dynamic->attachments)){
                $attachments = UpdateFile::whereRaw('id in ('. $dynamic->attachments.')')->get();
                $dynamic->attachments = $attachments;
            }

            if(!empty($dynamic->company->business_brands)){
                $dynamic->company->business_brands = Brand::whereRaw('id in ('.$dynamic->company->business_brands.')')->get();
            }

            if(!empty($dynamic->company->business_categories)){
                $dynamic->company->business_categories = Category::whereRaw('id in ('.$dynamic->company->business_categories.')')->get();
            }
        }

        $view = view('partials.dynamic', ['data'=>$rs]);
        return response()->json(['count'=>count($rs), 'html'=> (string)$view, 'lastTime'=>(string)($rs[count($rs)-1]->created_at)]);
    }
}
