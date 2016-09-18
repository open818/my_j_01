@extends('layouts.user_master')

@section('css')
    @parent
@show

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
                <div class="col-md-9">
                    <input type="text" name="name" class="form-control" readonly value="{{ old('name') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">公司地址：</label>
                <div class="col-md-9 form-inline">
                    <div id="company_distpicker" data-toggle="distpicker">
                        <select id="province" name="province" class="form-control distpicker_change" data-province="{{old('province')}}"></select>
                        <select id="city" name="city" class="form-control distpicker_change" data-city="{{old('city')}}"></select>
                    </div>
                </div>
            </div>

            <div class="form-group{{ $errors->has('address_details') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label">详细地址：</label>
                <div class="col-md-9">
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
                <div class="col-md-9">
                    <select id="business_circle" name="business_circle_id" class="form-control">

                    </select>
                </div>
            </div>

            <div class="form-group{{ $errors->has('profile') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label">公司简介：</label>
                <div class="col-md-9">
                    <textarea rows="5" class="form-control" name="profile">{{ old('profile') }}</textarea>
                    @if ($errors->has('profile'))
                    <span class="help-block">
                        <strong>{{ $errors->first('profile') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa fa-btn fa-sign-in"></i> 提交
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
            placeholder: false
        });

        function initBusinessCircle(select_id){
            var circle = $('#business_circle');
            circle.empty();
            $("<option>暂无</option>").appendTo(circle);
            var url = "/circle/dist";
            if($('#province').val() != ''){
                url = url + '/' + $('#province').val();
                if($('#city').val() != ''){
                    url = url + '/' + $('#city').val();
                }
            }
            $.ajax({
                type: 'GET',
                url: url ,
                success: function(data) {
                    $.each(data,function(n,value){
                        if(select_id == value.id){
                            $("<option selected value='" + value.id + "'>" + value.name + "</option>").appendTo(circle);//动态添加Option子项
                        }else{
                            $("<option value='" + value.id + "'>" + value.name + "</option>").appendTo(circle);//动态添加Option子项
                        }
                    });
                } ,
                dataType: 'json'
            });
        }

        $('.distpicker_change').change(function(){
            initBusinessCircle('');
        });

        $(document).ready(function(){
            initBusinessCircle({{old('business_circle_id')}});
        });
    </script>
@stop
