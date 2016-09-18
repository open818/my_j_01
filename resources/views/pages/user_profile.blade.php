@extends('layouts.user_master')

@section('css')
    @parent
    {!! Html::style('/bower/bootstrap-fileinput/css/fileinput.min.css') !!}
@show

@section('center_content')
    <div class="panel panel-default">
        <div class="panel-heading">
            个人设置
        </div>

        <div class="panel-body">
            {!! Form::open(['url'=>'user/saveProfile', 'method'=>'post', 'Enctype'=>'multipart/form-data',  'class'=>'form-horizontal']) !!}
            <div class="form-group">
                <label class="col-md-4 control-label">手机号码：</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" readonly value="{{ old('mobile') }}">
                </div>
            </div>

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">真实姓名：</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">邮箱：</label>

                <div class="col-md-6">
                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}">

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('QQ') ? ' has-error' : '' }}">
                <label for="QQ" class="col-md-4 control-label">QQ号：</label>

                <div class="col-md-6">
                    <input id="QQ" type="text" class="form-control" name="QQ" value="{{ old('QQ') }}">

                    @if ($errors->has('QQ'))
                        <span class="help-block">
                            <strong>{{ $errors->first('QQ') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">座机：</label>

                <div class="col-md-6">
                    <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}">

                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa fa-btn fa-sign-in"></i> 修改
                    </button>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('scripts')
    @parent
    {!! Html::script('/bower/bootstrap-fileinput/js/fileinput.min.js') !!}
    {!! Html::script('/bower/bootstrap-fileinput/themes/fa/theme.js') !!}
    {!! Html::script('/bower/bootstrap-fileinput/js/locales/zh.js') !!}
    <script>
        $(function(){
            $("#input-id").fileinput({
                'language': 'zh',
                'showUpload': false, //是否显示上传按钮
                'allowedFileExtensions' : ['jpg', 'png','gif'],
            });
        });
    </script>
@stop
