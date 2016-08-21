@extends('layouts.master')

@section('css')
    @parent
@show

@section('navigation')
    <div class="container">
        <div class="row panel panel-default">
            <div class="panel-body">
                <h1>{{$company->name}}</h1>
                经营地址：{{$company->business_address}}{{$company->address_details}}<br/>
                联系电话：{{$company->tel}} 传真：{{$company->fax}}<br/>
                电子邮箱：{{$company->email}} 网址：{{$company->url}}<br/>
            </div>
        </div>
    </div>
@stop

@section('breadcrumbs')
    <div class="row">
        <ul class="tab-list" style="padding: 0">
            <li><a href="project_detail.html"><i class="fa fa-tag"></i> 基本信息</a>
            </li>
            <li><a href="project_detail.html"><i class="fa fa-tag"></i> 工商信息</a>
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
                    @if(!empty($company->employees))
                        <ul>
                            @foreach($company->employees as $employee)
                                <li>
                                    {{$employee->user->name}}/{{$employee->position}}
                                </li>
                            @endforeach
                        </ul>
                    @endif
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
