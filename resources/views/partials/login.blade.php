<!-- Login -->
<div class="panel panel-default">
    <div class="panel-heading">
        使用手机号码登录
    </div>

    <div class="panel-body">
        {!! Form::open(['url'=>'login', 'method'=>'post', 'class'=>'form-horizontal']) !!}
        <div class="form-group">
            <div class="col-md-6">
                <label for="login_switch1">
                    <input type="radio" name="phone-login" id="login_switch1" onclick="toGetFWCode()" @if(!old('phone-login') || old('phone-login') == 'psw') checked="" @endif  value="psw">
                    <span>密码验证登录</span>
                </label>
            </div>
            <div class="col-md-6">
                <label for="login_switch2">
                    <input type="radio" name="phone-login" id="login_switch2" onclick="toGetSMSCode()" @if(old('phone-login') && old('phone-login') == 'sms') checked="" @endif value="sms">
                    <span>短信验证登录</span>
                </label>
            </div>
        </div>

        <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
            <div class="col-md-12">
                <input id="mobile" type="number" placeholder="手机号" class="form-control" name="mobile" value="{{ old('mobile') }}">

                @if ($errors->has('mobile'))
                    <span class="help-block">
                            <strong>{{ $errors->first('mobile') }}</strong>
                        </span>
                @endif
            </div>
        </div>

        <div id="div_psw" class="form-group{{ $errors->has('password') ? ' has-error' : '' }} @if(old('phone-login') && old('phone-login') == 'sms') hidden @endif">
            <div class="col-md-12">
                <input id="password" placeholder="登录密码"  type="password" class="form-control" name="password">

                @if ($errors->has('password'))
                    <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                @endif
            </div>
        </div>

        <div id="div_code" class="form-group{{ $errors->has('verifyCode') ? ' has-error' : '' }} @if(old('phone-login') && old('phone-login') == 'sms') show @else hidden @endif">
            <div class="col-md-12">
                <div class="input-group">
                    <input id="code" placeholder="短信验证码" type="text" class="form-control" name="verifyCode">
                    <span class="input-group-btn">
                        <button type="button" id="btn_send_sms" class="btn btn-primary">
                            <i class="fa fa-btn fa-sign-in"></i> 获取验证码
                        </button>
                    </span>
                </div>
                @if ($errors->has('verifyCode'))
                    <span class="help-block">
                        <strong>{{ $errors->first('verifyCode') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6">
                <a class="btn btn-link" href="{{ url('/password/reset') }}">忘记密码？</a>
            </div>
            <div class="col-md-6">
                <a class="btn btn-link pull-right" href="{{ url('/register') }}">用户注册</a>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fa fa-btn fa-sign-in"></i> 登录
                </button>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
</div>
<script>
    function toGetFWCode(){
        $("#div_psw").removeClass("hidden");
        $("#div_psw").addClass("show");
        $("#div_code").removeClass("show");
        $("#div_code").addClass("hidden");
    }

    function toGetSMSCode(){
        $("#div_code").removeClass("hidden");
        $("#div_code").addClass("show");
        $("#div_psw").removeClass("show");
        $("#div_psw").addClass("hidden");
    }

    $('#btn_send_sms').sms({
        //laravel csrf token
        token       : "{{csrf_token()}}",
        //请求间隔时间
        interval    : 60,
        //请求参数
        requestData : {
            //手机号
            mobile : function () {
                return $('#mobile').val();
            },
            //手机号的检测规则
            mobile_rule : 'mobile_required'
        }
    });
</script>