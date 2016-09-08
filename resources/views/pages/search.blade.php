@extends('layouts.master')

@section('title')@parent - 搜索结果 @stop

@section('content')
    <section class="products_view">

        <div class="container">
            @parent

            @section('center_content')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        搜索结果
                    </div>
                    <div class="panel-body">
                        <div style="margin-bottom: 10px;">
                            @if(!empty($province_s))
                            <div class="search_condition" data-index="3">
                                地区：<a class="active condition">所有</a>
                                @foreach($province_s as $key => $v)
                                    <a class="condition" data-id="{{$key}}">{{$v}}</a>
                                @endforeach
                            </div>
                            @endif
                            @if(count($categories)>0)
                            <div class="search_condition" data-index="1">
                                类目：<a class="active condition">所有</a>
                                @foreach($categories as $category)
                                    <a class="condition" data-id="{{$category->id}}">{{$category->name}}</a>
                                @endforeach
                            </div>
                            @endif
                            @if(count($categories)>0)
                            <div class="search_condition" data-index="2">
                                品牌：<a class="active condition">所有</a>
                                    @foreach($brands as $brand)
                                        <a class="condition" data-id="{{$brand->id}}">{{$brand->name}}</a>
                                    @endforeach
                            </div>
                            @endif
                        </div>

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
        var id1 = 0;
        var id2 = 0;
        var id3 = '';
        var loading = false;

        function loadDynamicData(){
            if(!loading){
                loading = true;
                var url = "/search_item/{{$search_key}}/" + lastid;

                $.ajax({
                    type: 'GET',
                    url: url ,
                    data: {id1:id1,id2:id2,area:id3},
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

        $(".condition").click(function(){
            if($(this).hasClass('active')){
                return '';
            }

            var index = $(this).parent().attr('data-index');
            var v = $(this).attr('data-id');
            lastid=0;
            eval( "id"+ index +" ='"+v+"';");
            $('.search_company > ul').html('');
            $("#item_end").hide();
            loadDynamicData();
            $(this).parent().children('a').removeClass('active');
            $(this).addClass('active');
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