<!-- Register -->
<div class="row">
    <form action="register" class="form-horizontal" method="post">
        {{ csrf_field() }}

        <div class="form-group text-center">
            <h3><label>用户注册</label></h3>
        </div>

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">真实姓名：</label>

            <div class="col-md-6">
                <input id="name" type="tel" placeholder="用于别人按人名搜索" class="form-control" name="name" value="{{ old('name') }}">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
            <label for="mobile" class="col-md-4 control-label">手机号：</label>

            <div class="col-md-6">
                <input id="mobile" type="tel" placeholder="登录用，且方便他人联系" class="form-control" name="mobile" value="{{ old('mobile') }}">

                @if ($errors->has('mobile'))
                    <span class="help-block">
                        <strong>{{ $errors->first('mobile') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
            <label for="code" class="col-md-4 control-label">验证码：</label>

            <div class="col-md-6">
                <div class="input-group">
                    <input id="code" type="text" class="form-control" name="code">
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

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label">密&nbsp;码：</label>

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
                    <i class="fa fa-btn fa-sign-in"></i> 注册
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-5 control-label">
                <a class="btn btn-link" href="{{ url('/password/reset') }}">忘记密码？</a>
            </div>
            <div class="col-md-5">
                <a class="btn btn-link pull-right" href="{{ url('/') }}">用户登录</a>
            </div>
        </div>
    </form>
</div>