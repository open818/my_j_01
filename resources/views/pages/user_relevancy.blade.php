@extends('layouts.user_master')

@section('title')@parent - 首页 @stop

@section('center_content')
    <div class="panel panel-default">
        <div class="panel-heading">
            选择关联公司
        </div>

        <div class="panel-body">
            {!! Form::open(['url'=>'/user/relevancy', 'method'=>'post', 'class'=>'form-horizontal']) !!}
            <div class="form-group">
                <label for="name" class="col-md-4 control-label">所属公司：</label>

                <div class="col-md-6">
                    <input id="company_name" type="text" class="form-control" name="company_name">
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-md-4 control-label">所在职位：</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="position">
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-md-4 control-label">负责区域：</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="territory">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-5 control-label">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-sign-in"></i> 选择关联
                    </button>
                </div>
                <div class="col-md-5">
                    <button type="button" class="btn btn-primary" onclick="javascript:window.location.href='/'">
                        <i class="fa fa-btn fa-sign-in"></i> 暂不关联
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop {{-- end center_content --}}