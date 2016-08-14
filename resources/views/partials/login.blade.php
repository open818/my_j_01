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
                    <input type="radio" name="phone-login" id="login_switch1" onclick="toGetFWCode()" checked="">
                    <span>服务密码</span>
                </label>
            </div>
            <div class="col-md-6">
                <label for="login_switch2">
                    <input type="radio" name="phone-login" id="login_switch2" onclick="toGetSMSCode()">
                    <span>短信密码</span>
                </label>
            </div>
        </div>

        <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
            <div class="col-md-12">
                <input id="mobile" type="tel" placeholder="手机号" class="form-control" name="mobile" value="{{ old('mobile') }}">

                @if ($errors->has('mobile'))
                    <span class="help-block">
                            <strong>{{ $errors->first('mobile') }}</strong>
                        </span>
                @endif
            </div>
        </div>

        <div id="div_psw" class="form-group{{ $errors->has('password') ? ' has-error' : '' }} show">
            <div class="col-md-12">
                <input id="password" placeholder="登录密码"  type="password" class="form-control" name="password">

                @if ($errors->has('password'))
                    <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                @endif
            </div>
        </div>

        <div id="div_code" class="form-group{{ $errors->has('code') ? ' has-error' : '' }} hidden">
            <div class="col-md-12">
                <div class="input-group">
                    <input id="code" placeholder="短信验证码" type="text" class="form-control" name="code">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-primary">
                            <i class="fa fa-btn fa-sign-in"></i> 获取验证码
                        </button>
                    </span>
                </div>
                @if ($errors->has('code'))
                    <span class="help-block">
                        <strong>{{ $errors->first('code') }}</strong>
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
</script>