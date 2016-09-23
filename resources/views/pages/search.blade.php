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
                        <div id="conditions" style="margin-bottom: 10px;">
                            @if(!empty($province_s))
                            <div class="search_condition" data-index="1">
                                地区：<button class="active condition">所有</button>
                                @foreach($province_s as $key => $v)
                                    <button class="condition" data-id="{{$key}}">{{$v}}</button>
                                @endforeach
                            </div>
                            @endif

                            <div id="condition_circle" class="search_condition" data-index="2">
                            </div>
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
    {!! Html::script('/bower/jQuery.dotdotdot/src/jquery.dotdotdot.min.js') !!}
    <script>
        var lastid = 1;
        var id1 = '';
        var id2 = 0;
        var loading = false;

        function loadDynamicData(){
            if(!loading){
                loading = true;
                var url = "/search_item/{{$search_key}}/" + lastid;

                $.ajax({
                    type: 'GET',
                    url: url ,
                    data: {area:id1, circle_id:id2},
                    success: function(data) {
                        if(data.count > 0){
                            if(data.circles.length > 0){
                                var circle_html = '商圈：<button class="active condition">所有</button>'
                                for(var o in data.circles){
                                    circle_html = circle_html + '<button class="condition" data-id="'+data.circles[o].id+'">'+data.circles[o].name+'</button>';
                                }
                                $('#condition_circle').html(circle_html);
                            }else if(id2 == 0){
                                $('#condition_circle').html('商圈：<button class="active condition">所有</button>');
                            }

                            var _ul = $('.search_company > ul');
                            $(data.html).appendTo(_ul);
                            lastid = data.lastid;
                            $(".dotdotdot").dotdotdot({
                                ellipsis	: '...',
                                wrap		: 'word',
                                fallbackToLetter: true,
                                after		: null,
                                watch		: false,
                                height		: 80
                            });
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

        $('#conditions').on('click','.condition', function(){
            if($(this).hasClass('active')){
                return '';
            }

            var index = $(this).parent().attr('data-index');
            var v = $(this).attr('data-id');
            lastid=1;
            if(index == 1){
                id1 = v;
                id2 = 0;
                $('#condition_circle').html();
            }else if(index == 2){
                id2 = v;
            }
            $('.search_company > ul').html('');
            $("#item_end").hide();
            loadDynamicData();
            $(this).parent().children('button').removeClass('active');
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