<!-- Register -->
<div class="panel panel-default">
    <div class="panel-body">
        {!! Form::open(['url'=>'password/reset', 'method'=>'post', 'class'=>'form-horizontal']) !!}
        @if(!Auth::user())
        <div class="form-group text-center">
            <h3><label>重置密码</label></h3>
        </div>
        @endif

        <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
            <label for="mobile" class="col-md-4 control-label">手机号：</label>

            <div class="col-md-6">
                @if(!Auth::user())
                <input id="mobile" type="tel" placeholder="登录手机号" class="form-control" name="mobile" value="{{ old('mobile') }}">
                @else
                    <input id="mobile" type="tel" readonly class="form-control" name="mobile" value="{{ Auth::user()->mobile}}">
                @endif

                @if ($errors->has('mobile'))
                    <span class="help-block">
                        <strong>{{ $errors->first('mobile') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('verifyCode') ? ' has-error' : '' }}">
            <label for="code" class="col-md-4 control-label">验证码：</label>

            <div class="col-md-6">
                <div class="input-group">
                    <input id="code" type="text" class="form-control" name="verifyCode">
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

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label">新密码：</label>

            <div class="col-md-6">
                <input id="password" placeholder="不能小于6位"  type="password" class="form-control" name="password">

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fa fa-btn fa-sign-in"></i> 提交
                </button>
            </div>
        </div>

        @if(!Auth::user())
        <div class="form-group">
            <div class="col-md-5 control-label">
                <a class="btn btn-link" href="{{ url('/password/reset') }}">忘记密码？</a>
            </div>
            <div class="col-md-5">
                <a class="btn btn-link pull-right" href="{{ url('/') }}">用户登录</a>
            </div>
        </div>
        @endif
        {!! Form::close() !!}
    </div>
</div>
<script>
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