@extends('layouts.master')

@section('css')
    @parent
@show

@section('navigation')
    <div class="container" style="margin-top: 5px;">
        <div class="row panel panel-default">
            <div class="panel-body">
                <h1>{{$company->name}}</h1>
                经营地址：{{$company->business_address}}{{$company->address_details}}
                @if($company->circle)
                    ({{$company->circle->name}})
                @endif
                <br/>
            </div>
        </div>
    </div>
@stop

@section('breadcrumbs')
    <div class="row">
        <ul class="tab-list" style="padding: 0">
            @if($company->gsxt_url)
                <li><a href="{{$company->gsxt_url}}"><i class="fa fa-tag"></i> 更多工商信息</a></li>
            @endif
        </ul>
    </div>
@stop

@section('panel_left_content')
    <div class="panel panel-default">
        <div class="panel-heading">
            联系人
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                @foreach($company->employees as $employee)
                    <tr>
                        <td>
                            <a href="javascript:void(0)" class="pop" data-toggle="popover"
                            data-id="{{$employee->user->id}}" >{{$employee->user->name}}</a></td>
                        <td>{{$employee->position}}</td>
                        <td>{{$employee->territory}}</td>
                    </tr>
                @endforeach
            </table>

            <!-- 模态框（Modal） -->
            <div class="modal fade" id="message_modal" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close"
                                    data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                信息留言 - <label id="m_message_user"></label>
                            </h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::open(['id'=>'modal_form', 'url'=>'/user/message/add', 'method'=>'post']) !!}
                            <input type="hidden" id="m_user_id" name="to">
                            <textarea rows="3" id="m_content" name="content" style="width: 100%;"></textarea>
                            {!! Form::close() !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal">关闭
                            </button>
                            <button type="button" id="m_sumit" class="btn btn-primary">
                                提交
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal -->
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            公司简介
        </div>
        <div class="panel-body">
            <pre style="white-space: pre-wrap;word-wrap: break-word;border: 0px;line-height: 2;">{{$company->profile}}</pre>
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
        <div id="item_end" class="panel-footer" style="text-align:center;display: none;">
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
                    if(data.count > 0){
                        var _ul = $('.company_dynamic > ul');
                        $(data.html).appendTo(_ul);
                        lastTime = data.lastTime;
                        loading = false;
                    }else{
                        if(lastTime == ''){
                            $("#item_end").html('查询暂无数据').show();
                        }else{
                            $("#item_end").html('已是最后一条数据').show();
                        }

                    }
                } ,
                dataType: 'json'
            });
        }
    }

    $(function() {
        $("td").on('click', '.pop', function(){
            var obj = $(this);
            obj.off('click');
            $.ajax({
                url : '/popover/userinfo/'+obj.attr('data-id'),
                type : 'get',
                async: false,
                success : function(data){
                    obj.popover({
                        html: true,
                        trigger: 'click',
                        placement: 'bottom',
                        container: 'body',
                        content: data,
                        delay: { "show": 500, "hide": 200 }
                    }).popover('show');
                },
            });
        });

        $("#m_sumit").click(function(){
            var content = $('#m_content').val();
            if($.trim(content) != ''){
                $( "#modal_form" ).submit();
            }
        });
    });

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
