@extends('layouts.master')

@section('title')@parent - 找圈子、找渠道、找人脉，扩生意圈子，展商机信息，让做生意更轻松！ @stop

@section('content')
    <section class="products_view">

        <div class="container">
            {{-- -------------------------------------------------- --}}
            {{-- ------------------ Product List ------------------ --}}
            {{-- -------------------------------------------------- --}}

            @parent

            @section('center_content')

                {{-- -------------------------------------------------- --}}
                {{-- -------------------- 广播图 -------------------- --}}
                {{-- -------------------------------------------------- --}}
                <div class="home-carousel-box">
                    <div id="store-home-carousel" class="carousel slide" data-ride="carousel">
                        {{-- indicators --}}
                        <ol class="carousel-indicators">
                            @for ($s=0; $s<count($banners); $s++)
                                <li data-target="#store-home-carousel" data-slide-to="{{ $s }}" @if ($s==0) class="active" @endif ></li>
                            @endfor
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <?php $pos = 0; ?>
                            @foreach ($banners as $banner)

                                {{-- slide items --}}
                                <div class="item @if ($pos++==0) active @endif">
                                    <img src="{{ $banner['img'] }}" alt="{{ $banner['alt'] }}" @if (isset($banner['url'])) onclick="javascript:window.location.href='{{ $banner['url'] }}'" @endif>

                                </div> {{-- end item --}}

                            @endforeach

                        </div> {{-- end carousel-inner --}}

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
                </div> {{-- end carousel --}}

                <div class="panel panel-default">
                    <div class="panel-heading">
                        商机动态
                    </div>
                    <div class="panel-body">
                        <div class="search_condition" style="margin-bottom: 20px;">
                            <button class="active condition">所有行业</button>
                            @foreach($categories as $category)
                                <button class="condition" data-id="{{$category->id}}">{{$category->name}}</button>
                            @endforeach
                        </div>
                        <div class="company_dynamic">
                            <input type="hidden" id="lastTime" />
                            <ul class="list-group">
                            </ul>
                        </div>
                    </div>
                    <div id="item_end" class="panel-footer" style="text-align:center;display: none;"></div>
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
        var lastTime = '';
        var id1 = 0;
        var loading = false;

        function loadDynamicData(){
            if(!loading){
                loading = true;
                var url = "/index/dynamic/"+lastTime;

                $.ajax({
                    type: 'GET',
                    url: url ,
                    data: {id1:id1},
                    success: function(data) {
                        if(data.count > 0){
                            var _ul = $('.company_dynamic > ul');
                            $(data.html).appendTo(_ul);
                            lastTime = data.lastTime;
                        }else{
                            if(lastTime == ''){
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

        $(function() {
            $("ul").on('click', '.pop', function(){
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

            $(".condition").click(function(){
                if($(this).hasClass('active')){
                    return '';
                }

                id1 = $(this).attr('data-id');
                lastTime='';
                $('.company_dynamic > ul').html('');
                $("#item_end").hide();
                loadDynamicData();
                $(this).parent().children('button').removeClass('active');
                $(this).addClass('active');
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
