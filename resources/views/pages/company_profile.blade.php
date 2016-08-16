@extends('layouts.user_master')

@section('css')
    @parent
    {!! Html::style('/bower/bootstrap-select/dist/css/bootstrap-select.min.css') !!}
    {!! Html::style('/bower/ztree/css/zTreeStyle/zTreeStyle.css') !!}
@show

@section('center_content')
    <div class="panel panel-default">
        <div class="panel-heading">
            公司设置
        </div>

        <div class="panel-body">
            {!! Form::open(['url'=>'company/edit', 'method'=>'post',  'class'=>'form-horizontal']) !!}
            <div class="form-group">
                <label class="col-md-3 control-label">公司名称：</label>
                <input type="hidden" name="id" value="{{ old('id') }}">
                <div class="col-md-9">
                    <input type="text" name="name" class="form-control" readonly value="{{ old('name') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">公司地址：</label>
                <div class="col-md-9 form-inline">
                    <div id="company_distpicker" data-toggle="distpicker">
                        <select name="province" class="form-control" data-province="{{old('province')}}"></select>
                        <select name="city" class="form-control" data-city="{{old('city')}}"></select>
                        <select name="district" class="form-control" data-district="{{old('district')}}"></select>
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
                <label class="col-md-3 control-label">所属商圈：</label>
                <div class="col-md-9">
                    <select name="business_circle_id" class="form-control">
                        <option value="">暂无</option>
                        @foreach(\App\Helpers\BusinessCircleHelper::select(true) as $circle)
                            <option @if(old('business_circle_id') == $circle['id']) selected @endif value="{{$circle['id']}}">{{$circle['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group{{ $errors->has('tel') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label">联系电话：</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="tel" value="{{ old('tel') }}">
                    @if ($errors->has('tel'))
                        <span class="help-block">
                        <strong>{{ $errors->first('tel') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('fax') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label">传真：</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="fax" value="{{ old('fax') }}">
                    @if ($errors->has('fax'))
                        <span class="help-block">
                        <strong>{{ $errors->first('fax') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label">邮箱：</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label">网址：</label>
                <div class="col-md-9">
                    <div class="input-group">
                        <span class="input-group-addon">Http://</span>
                        <input type="text" class="form-control" name="url" value="{{ old('url') }}">
                    </div>

                    @if ($errors->has('url'))
                        <span class="help-block">
                        <strong>{{ $errors->first('url') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('profile') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label">公司简介：</label>
                <div class="col-md-9">
                    <textarea class="form-control" name="profile">{{ old('profile') }}</textarea>
                    @if ($errors->has('profile'))
                    <span class="help-block">
                        <strong>{{ $errors->first('profile') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">经营品牌：</label>
                <div class="col-md-9">
                    <select name="business_brand[]" class="form-control selectpicker" multiple data-live-search="true">
                        @foreach(\App\Helpers\BrandHelper::getAllBrand() as $brand)
                            <option value="{{$brand->id}}" @if(strpos(','.old('business_brands').',' ,','.$brand->id.',')) selected @endif >{{$brand->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">经营类目：</label>
                <div class="col-md-9">
                    <input type="text" placeholder="请点击选择" class="selectcategory form-control" readonly>
                    <input type="hidden" name="business_categories" id="business_categories">
                    <div id="menuContent" class="menuContent" style="display:none; position: absolute;z-index: 1000;">
                        <ul id="treeDemo" class="ztree" style="margin-top:0; width:180px; height: 300px;"></ul>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa fa-btn fa-sign-in"></i> 修改
                    </button>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('scripts')
    @parent
    {!! Html::script('/bower/distpicker/dist/distpicker.data.min.js') !!}
    {!! Html::script('/bower/distpicker/dist/distpicker.min.js') !!}
    {!! Html::script('/bower/bootstrap-select/dist/js/bootstrap-select.min.js') !!}
    {!! Html::script('/bower/ztree/js/jquery.ztree.core-3.5.min.js') !!}
    {!! Html::script('/bower/ztree/js/jquery.ztree.excheck-3.5.min.js') !!}
    <script>

        $('#company_distpicker').distpicker({
            placeholder: false
        });

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
                {id:{{$category->id}}, pId:{{$category->p_id}}, name:"{{$category->name}}" @if($category->p_id == 0) ,nocheck:true @endif},
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
