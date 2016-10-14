<?php

namespace App\Http\Controllers\Auth;

use App\Models\CompanyUser;
use Auth;
use App\Models\LogUserLogin;
use App\Models\User;
use Toplan\Sms\Facades\SmsManager;
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
            'verifyCode'  => 'required|verify_code',
            'password' => 'required|min:6|max:20',
        ],[
            'name.required' => '真实姓名必填',
            'name.max' => '真实姓名过长',
            'mobile.required' => '手机号必填',
            'mobile.regex' => '手机号格式不正确',
            'mobile.unique' => '当前手机号已注册',
            'verifyCode.required'   => '手机验证码不能为空',
            'verifyCode.verify_code' => '手机验证码不正确',
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
            'phone-login'   => 'required'
            //'password' => 'required',
        ],[
            $this->loginUsername().'.required' => '手机号不能为空',
            'phone-login'   => '访问错误',
            'password.required' => '密码不能为空',
        ]);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if($request->input('phone-login') == 'sms'){
            $guard = Auth::guard($this->getGuard());

            $user = $guard->getProvider()->retrieveByCredentials($credentials);
            if($user){

                $validator = Validator::make($request->all(), [
                    'verifyCode' => 'required|verify_code',
                ], [
                    'verifyCode.required'   => '验证码不能为空',
                    'verifyCode.verify_code' => '验证码不正确',
                ]);
                if ($validator->fails()) {
                    //验证失败后建议清空存储的发送状态，防止用户重复试错
                    //SmsManager::forgetState();
                    return $this->throwValidationException($request, $validator);
                    //return redirect()->back()->withErrors($validator);
                }

                $guard->login($user, $request->has('remember'));
                $this->login_logs($request);
                return $this->handleUserWasAuthenticated($request, $throttles);
            }
        }else{
            if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
                //写入登录日志
                $this->login_logs($request);
                return $this->handleUserWasAuthenticated($request, $throttles);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'phone-login'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
        //return $this->sendFailedLoginResponse($request);
    }

    /**
     * 创建用户
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $this->redirectTo = '/user/relevancy';

        return User::create([
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
        ]);
    }

    private function login_logs($request){
        $data = [
            'user_id'=>Auth::user()->id,
            'login_mobile'=>Auth::user()->mobile,
            'login_ip'=>$request->ip(),
            'source'=>'浏览器',
            'user_agent'=>$request->header('user-agent')
        ];
        LogUserLogin::create($data);
    }
}
