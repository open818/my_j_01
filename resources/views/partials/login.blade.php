<!-- Login -->
<div class="row">
    {!! Form::open(['url'=>'login', 'method'=>'post', 'class'=>'form-horizontal']) !!}
    <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
        <div class="col-md-10">
            <input id="mobile" type="tel" placeholder="手机号" class="form-control" name="mobile" value="{{ old('mobile') }}">

            @if ($errors->has('mobile'))
                <span class="help-block">
                        <strong>{{ $errors->first('mobile') }}</strong>
                    </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <div class="col-md-10">
            <input id="password" placeholder="登录密码"  type="password" class="form-control" name="password">

            @if ($errors->has('password'))
                <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-10">
            <button type="submit" class="btn btn-primary btn-block">
                <i class="fa fa-btn fa-sign-in"></i> 登录
            </button>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-5">
            <a class="btn btn-link" href="{{ url('/password/reset') }}">忘记密码？</a>
        </div>
        <div class="col-md-5">
            <a class="btn btn-link pull-right" href="{{ url('/register') }}">用户注册</a>
        </div>
    </div>
    {!! Form::close() !!}
</div>