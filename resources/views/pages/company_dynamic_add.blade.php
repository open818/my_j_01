@extends('layouts.user_master')

@section('css')
    @parent
    {!! Html::style('/bower/bootstrap-select/dist/css/bootstrap-select.min.css') !!}
    {!! Html::style('/bower/ztree/css/zTreeStyle/zTreeStyle.css') !!}
@show

@section('center_content')
    <div class="panel panel-default">
        <div class="panel-heading">
            发布商机
        </div>

        <div class="panel-body">
            {!! Form::open(['url'=>'company/dynamic/add', 'method'=>'post',  'class'=>'form-horizontal']) !!}
            <div class="form-group">
                <label class="col-md-3 control-label">类型：</label>
                <div class="col-md-9">
                    <div class="radio">
                        <label>
                            <input type="radio" checked value="1" name="type">我在销售
                        </label>
                    </div>

                    <div class="radio">
                        <label>
                            <input type="radio" checked value="1" name="type">我在求购
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">归属品牌：</label>
                <div class="col-md-9">
                    <select name="brand_id" class="form-control selectpicker" data-live-search="true">
                        @foreach(\App\Helpers\BrandHelper::getAllBrand() as $brand)
                            <option value="{{$brand->id}}" @if(old('brand->id') == $brand->id) selected @endif >{{$brand->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">归属类目：</label>
                <div class="col-md-9">
                    <input type="text" placeholder="请点击选择" class="selectcategory form-control" readonly>
                    <input type="hidden" name="business_categories" id="business_categories">
                    <div id="menuContent" class="menuContent" style="display:none; position: absolute;z-index: 1000;">
                        <ul id="treeDemo" class="ztree" style="margin-top:0; width:180px; height: 300px;"></ul>
                    </div>
                </div>
            </div>

            <div class="form-group{{ $errors->has('address_details') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label">详细地址：</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="address_details" value="{{ old('address_details') }}">

                    @if ($errors->has('address_details'))
                        <span class="help-block">
                        <strong>{{ $errors->first('address_details') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa fa-btn fa-sign-in"></i> 发布
                    </button>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('scripts')
    @parent
    {!! Html::script('/bower/bootstrap-select/dist/js/bootstrap-select.min.js') !!}
    {!! Html::script('/bower/ztree/js/jquery.ztree.core-3.5.min.js') !!}
    {!! Html::script('/bower/ztree/js/jquery.ztree.excheck-3.5.min.js') !!}
    <script>
        $('.selectpicker').selectpicker({noneSelectedText:'请选择'});

        $('.selectcategory').click(function(){
            showMenu(this);
        });

        var setting = {
            check: {
                enable: true,
                chkboxType: {"Y":"", "N":""}
            },
            view: {
                dblClickExpand: false
            },
            data: {
                simpleData: {
                    enable: true
                }
            },
            callback: {
                beforeClick: beforeClick,
                onCheck: onCheck
            }
        };

        var zNodes =[
                @foreach(\App\Helpers\CategoryHelper::getAll() as $category)
                {id:{{$category->id}}, pId:{{$category->p_id}}, name:"{{$category->name}}"
                @if($category->p_id == 0) ,nocheck:true @elseif(strpos(','.old('business_categories').',' ,','.$category->id.',') !== false) ,checked:true @endif},
                @endforeach
        ];

        function beforeClick(treeId, treeNode) {
            var zTree = $.fn.zTree.getZTreeObj("treeDemo");
            zTree.checkNode(treeNode, !treeNode.checked, null, true);
            return false;
        }

        function onCheck(e, treeId, treeNode) {
            var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
                    nodes = zTree.getCheckedNodes(true),
                    n = "", v = '';
            for (var i=0, l=nodes.length; i<l; i++) {
                n += nodes[i].name + ",";
                v += nodes[i].id + ",";
            }
            if (n.length > 0 ) n = n.substring(0, n.length-1);
            if (v.length > 0 ) v = v.substring(0, v.length-1);
            var cityObj = $(".selectcategory");
            cityObj.attr("value", n);
            $('#business_categories').attr('value', v);
        }

        function showMenu(obj) {
            var cityObj = $(obj);
            $("#menuContent").css({left:obj.offsetLeft + "px", top:obj.offsetTop + cityObj.outerHeight() + "px"}).slideDown("fast");
            $("#treeDemo").css({width: obj.offsetWidth});
            $("body").bind("mousedown", onBodyDown);
        }
        function hideMenu() {
            $("#menuContent").fadeOut("fast");
            $("body").unbind("mousedown", onBodyDown);
        }
        function onBodyDown(event) {
            if (!($(event.target).hasClass('selectcategory') || $(event.target).parents("#menuContent").length>0)) {
                hideMenu();
            }
        }

        $(document).ready(function(){
            $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        });
    </script>
@stop
