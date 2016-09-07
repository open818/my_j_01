@extends('layouts.user_master')

@section('title')@parent - 留言 @stop

@section('center_content')
    <div class="panel panel-default">
        <div class="panel-heading">
            留言信息
        </div>

        <div class="panel-body">
            <div class="message">
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
        var lastid = 0;
        var loading = false;

        function loadDynamicData(){
            if(!loading){
                loading = true;
                var url = "/user/message/show_item/" + lastid;

                $.ajax({
                    type: 'GET',
                    url: url ,
                    success: function(data) {
                        if(data.count > 0){
                            var _ul = $('.message > ul');
                            $(data.html).appendTo(_ul);
                            lastid = data.lastid;
                        }else{
                            if(lastid == 0){
                                $("#item_end").html('查询暂无数据').show();
                            }else{
                                $("#item_end").html('已是最后一条数据').show();
                            }

                        }

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