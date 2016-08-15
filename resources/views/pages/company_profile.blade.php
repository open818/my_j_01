@extends('layouts.user_master')

@section('center_content')
    <div class="panel panel-default">
        <div class="panel-heading">
            公司设置
        </div>

        <div class="panel-body">
            {!! Form::open(['url'=>'company/edit', 'method'=>'post',  'class'=>'form-horizontal']) !!}
            <div class="form-group">
                <label class="col-md-3 control-label">公司名称：</label>
                <input type="hidden" name="id" value="{{ old('id') }}">
                <div class="col-md-7">
                    <input type="text" name="name" class="form-control" readonly value="{{ old('name') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">公司地址：</label>
                <div class="col-md-7 form-inline">
                    <div id="company_distpicker" data-toggle="distpicker">
                        <select class="form-control" data-province="---- 选择省 ----"></select>
                        <select class="form-control" data-city="---- 选择市 ----"></select>
                        <select name="business_address" class="form-control" data-district="---- 选择区 ----"></select>
                    </div>
                </div>
            </div>

            <div class="form-group{{ $errors->has('address_details') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label">详细地址：</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="address_details" value="{{ old('address_details') }}">

                    @if ($errors->has('address_details'))
                        <span class="help-block">
                        <strong>{{ $errors->first('address_details') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">所属商圈：</label>
                <div class="col-md-7">
                    <select class="form-control">
                        <option value="">暂无</option>
                        @foreach(\App\Helpers\BusinessCircleHelper::select(true) as $circle)
                            <option @if(old('business_circle_id') == $circle['id']) selected @endif value="{{$circle['id']}}">{{$circle['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group{{ $errors->has('tel') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label">联系电话：</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="tel" value="{{ old('tel') }}">
                    @if ($errors->has('tel'))
                        <span class="help-block">
                        <strong>{{ $errors->first('tel') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('fax') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label">传真：</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="fax" value="{{ old('fax') }}">
                    @if ($errors->has('fax'))
                        <span class="help-block">
                        <strong>{{ $errors->first('fax') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label">邮箱：</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label">网址：</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="url" value="{{ old('url') }}">
                    @if ($errors->has('url'))
                        <span class="help-block">
                        <strong>{{ $errors->first('url') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('profile') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label">公司简介：</label>
                <div class="col-md-7">
                    <textarea class="form-control" name="profile">{{ old('profile') }}</textarea>
                    @if ($errors->has('profile'))
                    <span class="help-block">
                        <strong>{{ $errors->first('profile') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-7 col-md-offset-3">
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
    {!! Html::script('/bower/distpicker/dist/distpicker.data.min.js') !!}
    {!! Html::script('/bower/distpicker/dist/distpicker.min.js') !!}
    <script>
        $('#company_distpicker').distpicker({
            placeholder: false,
            valueType: 'code',
            province: "{{old('province')}}",
            city: "{{old('city')}}",
            district: "{{old('district')}}"
        });

    </script>
@stop
