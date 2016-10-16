<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\LogUserLogin;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('pages.password');
    }

    public function reset(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'mobile' => 'required|regex:/^1[34578][0-9]{9}$/',
            'verifyCode'  => 'required|verify_code',
            'password' => 'required|min:6|max:20',
        ],[
            'mobile.required' => '手机号必填',
            'mobile.regex' => '手机号格式不正确',
            'verifyCode.required'   => '手机验证码不能为空',
            'verifyCode.verify_code' => '手机验证码不正确',
            'password.required' => '密码必填',
            'password.min' => '密码长度过短',
            'password.max' => '密码长度过长',
        ]);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $credentials = $request->only('mobile');
        $guard = Auth::guard($this->getGuard());

        $user = $guard->getProvider()->retrieveByCredentials($credentials);

        if($user){
            $this->resetPassword($user, $request->input('password'));
            $data = [
                'user_id'=>$user->id,
                'login_mobile'=>$user->mobile,
                'login_ip'=>$request->ip(),
                'source'=>'浏览器',
                'user_agent'=>$request->header('user-agent')
            ];
            LogUserLogin::create($data);
            return redirect('/');
        }else{
            return redirect()->back()
                ->withInput($request->only($this->loginUsername()))
                ->withErrors([
                    $this->loginUsername() => Lang::get('auth.resetFailed'),
                ]);
        }
    }
}
