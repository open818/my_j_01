@extends('layouts.master')

@section('title')@parent - 搜索结果 @stop

@section('content')
    <section class="products_view">

        <div class="container">
            @parent

            @section('center_content')
                <div class="panel panel-default">
                    <div class="panel-body category">
                        <div class="box">
                            <div class="picbox">
                                <ul class="piclist mainlist">
                                    <li>所有</li>
                                    @foreach(\App\Helpers\CategoryHelper::getCategory() as $category)
                                        <li>{{$category->name}}</li>
                                    @endforeach
                                </ul>
                                <ul class="piclist swaplist"></ul>
                            </div>
                            <div class="og_prev"></div>
                            <div class="og_next"></div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        搜索结果
                    </div>
                    <div class="panel-body">
                        <div class="search_company">
                            <ul class="list-group">
                            </ul>
                        </div>
                    </div>
                    <div id="item_end" class="panel-footer" style="text-align:center;display: none;">
                    </div>
                </div>
            @stop {{-- end center_content --}}


            {{-- -------------------------------------------------- --}}
            {{-- -------------------- Right Bar -------------------- --}}
            {{-- -------------------------------------------------- --}}

            @section('panel_right_content')

                <div class="home-right-bar">

                    @if(Auth::user())
                        {{-- rated products tag --}}
                        @include('partials.user')
                    @else
                        {{-- rated products tag --}}
                        @include('partials.login')
                    @endif

                </div> {{-- end home-left-bar --}}

            @stop {{-- end panel_left_content --}}

        </div> {{-- end container-fluid --}}

    </section> {{-- end products_view --}}
@stop {{-- end content --}}

@section('scripts')
    @parent
    <script>
        var lastid = 0;
        var loading = false;

        function loadDynamicData(){
            if(!loading){
                loading = true;
                var url = "/search_item/{{$search_key}}/" + lastid;

                $.ajax({
                    type: 'GET',
                    url: url ,
                    success: function(data) {
                        if(data.count > 0){
                            var _ul = $('.search_company > ul');
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