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
        <div class="panel-body">
            <div class="profile">
                公司简介：{{$company->profile}}
            </div>

            <div class="employees">
                <div>
                    联系人：
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
        </div>
    </div>
@stop

@section('center_content')
    <div class="panel panel-default">
        <div class="panel-body">
            @include("partials.company_dynamic", ['data'=>$company->dynamics])
        </div>
    </div>
@stop

@section('scripts')
    @parent
@stop
