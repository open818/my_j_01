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
    private $page_size = 20;

    public function ajax_getByCompany($company_id, $lastTime = '')
    {
        if(empty($lastTime)){
            $lastTime = Carbon::now();
        }
        $rs = CompanyDynamic::where('company_id', $company_id)->where('created_at', '<', $lastTime)->orderby('created_at', 'desc')->take($this->page_size)->get();
        foreach($rs as &$dynamic){
            if(!empty($dynamic->attachments)){
                $attachments = UpdateFile::whereRaw('id in ('. $dynamic->attachments.')')->get();
                $dynamic->attachments = $attachments;
            }
        }
        //dd($rs[1]->attachments);

        $view = view('partials.company_dynamic', ['data'=>$rs]);
        return response()->json(['html'=> (string)$view]);
    }
}
