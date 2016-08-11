<?php

namespace App\Http\Controllers;

use App\Helpers\File;
use App\Models\User;
use Illuminate\Http\Request;
use \Auth;
use \Validator;

class UserController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Sube imagen de perfil y background de usuario.
     *
     * @param Request $request [description]
     *
     * @return [String] [Url de la imagen]
     */
    public function upload(Request $request)
    {
        $v = Validator::make($request->all(), ['file' => 'image'], ['file.image' => '必须是图片格式']);
        if ($v->fails()) {
            return $v->errors()->toJson();
        }

        return File::section('profile_img')->upload($request->file('file'));
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
}
