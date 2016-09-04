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
                        <td><i class="fa fa-phone"></i>{{$employee->user->mobile}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@stop

@section('center_content')
    <div class="panel panel-default">
        <div class="panel-heading">
            公司简介
        </div>
        <div class="panel-body">
            <pre style="white-space: pre-wrap;word-wrap: break-word;border: 0px;line-height: 2;">{{$company->profile}}</pre>
        </div>
    </div>

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
    var lastTime = '';
    var loading = false;

    function loadDynamicData(){
        if(!loading){
            loading = true;
            var url = "/company_dynamic/{{$company->id}}/"+lastTime;

            $.ajax({
                type: 'GET',
                url: url ,
                success: function(data) {
                    var _ul = $('.company_dynamic > ul');
                    $(data.html).appendTo(_ul);
                    lastTime = data.lastTime;
                    loading = false;
                } ,
                dataType: 'json'
            });

        }
    }

    $(document).ready(function(){
        loadDynamicData();

        var range = 50;             //距下边界长度/单位px
        var elemt = 500;           //插入元素高度/单位px
        var maxnum = 20;            //设置加载最多次数
        var num = 1;
        var totalheight = 0;
        var main = $("#content");                     //主体元素
        $(window).scroll(function(){
            var srollPos = $(window).scrollTop();    //滚动条距顶部距离(页面超出窗口的高度)

            //console.log("滚动条到顶部的垂直高度: "+$(document).scrollTop());
            //console.log("页面的文档高度 ："+$(document).height());
            //console.log('浏览器的高度：'+$(window).height());

            totalheight = parseFloat($(window).height()) + parseFloat(srollPos);
            if(($(document).height()-range) <= totalheight) {
                loadDynamicData();
            }
        });
    });
    </script>

@stop
