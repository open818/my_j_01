@extends('layouts.user_master')

@section('title')@parent - 首页 @stop

@section('center_content')
    <div class="panel panel-default">
        <div class="panel-heading">
            选择关联公司
        </div>

        <div class="panel-body">
            <div class="form-group">
                <label for="name" class="col-md-4 control-label">所属公司：</label>

                <div class="col-md-6">
                    <label for="name" class="control-label">{{$companies[0]->company->name}}</label>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-md-4 control-label">所在职位：</label>

                <div class="col-md-6">
                    <label for="name" class="control-label">{{$companies[0]->position}}</label>
                </div>
            </div>

            <div class="form-group">
                @if($companies[0]->status == 2)
                    <label>请稍后，待 {{$companies[0]->company->name}} 的 管理员{{$admin->name}}({{$admin->mobile}})审核！</label>
                @endif
            </div>
        </div>
    </div>
@stop {{-- end center_content --}}