<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $username = 'mobile';
    protected $registerView = 'pages.register';
    protected $loginView = 'pages.login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * 用户注册验证
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:10',
            'mobile' => 'required|regex:/^1[34578][0-9]{9}$/|unique:user',
            'code'  => 'required|regex:/^666666$/',
            'password' => 'required|min:6|max:20',
        ],[
            'name.required' => '真实姓名必填',
            'name.max' => '真实姓名过长',
            'mobile.required' => '手机号必填',
            'mobile.regex' => '手机号格式不正确',
            'mobile.unique' => '当前手机号已注册',
            'code.required' => '手机验证码不能为空',
            'code.regex' => '手机验证码不正确',
            'password.required' => '密码必填',
            'password.min' => '密码长度过短',
            'password.max' => '密码长度过长',
        ]);
    }

    /**
     * 用户登录验证
     * @param Request $request
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required',
            'password' => 'required',
        ],[
            $this->loginUsername().'.required' => '手机号不能为空',
            'password.required' => '密码不能为空',
        ]);
    }

    /**
     * 创建用户
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
