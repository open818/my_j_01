@extends('layouts.master')

@section('css')
    @parent
@show

@section('navigation')
    <div class="container">
        <div class="row panel panel-default">
            <div class="panel-body">
                <h1>{{$company->name}}</h1>
                经营地址：{{$company->business_address}}{{$company->address_details}}
                @if($company->circle)
                    ({{$company->circle->name}})
                @endif
                <br/>
                联系电话：{{$company->tel}} 传真：{{$company->fax}}<br/>
                电子邮箱：{{$company->email}} 网址：<a target="_blank" href="{{$company->url}}">{{$company->url}}</a><br/>
            </div>
        </div>
    </div>
@stop

@section('breadcrumbs')
    <div class="row">
        <ul class="tab-list" style="padding: 0">
            <li><a href="project_detail.html"><i class="fa fa-tag"></i> 基本信息</a>
            </li>
            <li><a href="{{$company->gsxt_url}}"><i class="fa fa-tag"></i> 工商信息</a>
            </li>
        </ul>
    </div>
@stop

@section('panel_left_content')
    <div class="panel panel-default">
        <div class="panel-heading">
            公司简介
        </div>
        <div class="panel-body">
            {{$company->profile}}
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            主营品牌
        </div>
        <div class="panel-body">
            @php($i=1) @foreach($company->business_brands as $brand) {{$brand->name}} @if($i != count($company->business_brands)) 、@php($i++) @endif @endforeach
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            主营类目
        </div>
        <div class="panel-body">
            @php($i=1) @foreach($company->business_categories as $cate) {{$cate->name}} @if($i != count($company->business_categories)) 、@php($i++) @endif @endforeach
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            联系人
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                @foreach($company->employees as $employee)
                    <tr>
                        <td>{{$employee->user->name}}</td>
                        <td>{{$employee->position}}</td>
                        <td>{{$employee->user->mobile}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@stop

@section('center_content')
    <div class="panel panel-default">
        <div class="panel-heading">
            企业动态
        </div>
        <div class="panel-body">
            <div class="company_dynamic">
                <input type="hidden" id="lastTime" />
                <ul class="list-group">
                </ul>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    @parent
    <script>
    function loadDynamicData(){
        time = $('#lastTime').val();
        var url = "/company_dynamic/{{$company->id}}/"+time;

        $.ajax({
            type: 'GET',
            url: url ,
            success: function(data) {
            var _ul = $('.company_dynamic > ul');
            $.each(data,function(n,value){
            $("<li class=\"list-group-item\"><small class=\"block text-muted\"><i class=\"fa fa-clock-o\"></i>"+value.created_at+"</small><p>"+value.content+"</p></li>").appendTo(_ul);
            });
            } ,
            dataType: 'json'
        });
    }

    $(document).ready(function(){
        loadDynamicData();
    });
    </script>

@stop
