@extends('layouts.user_master')

@section('title')@parent - 首页 @stop

@section('center_content')
    <div class="panel panel-default">
        <div class="panel-heading">
            公司员工
        </div>

        <div class="panel-body">
            <table class="table table-hover">
                <tbody>
                    @foreach($users as $user)
                    <td>
                        @if($user->status == 2)
                        <td><span class="label label-primary">待验证</span></td>
                        @else
                        <td><span class="label label-default">已验证</span></td>
                        @endif

                        <td>{{$user->user->name}}</td>
                        <td>{{$user->user->mobile}}</td>
                        <td>{{$user->position}}</td>
                        <td>
                            @if($user->status == 2)
                                <a href="/company/relevancy/apply/{{$user->id}}" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> 通过 </a>
                            @endif

                            @if($user->status == 1 && $user->isadmin == 'N')
                                <a href="/company/relevancy/admin/{{$user->id}}" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 管理员 </a>

                            @endif

                            @if($user->isadmin == 'N')
                                <a href="/company/relevancy/delete/{{$user->id}}" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> 删除 </a>
                            @endif
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop {{-- end center_content --}}