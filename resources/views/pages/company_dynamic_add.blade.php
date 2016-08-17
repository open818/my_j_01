@extends('layouts.user_master')

@section('css')
    @parent
    {!! Html::style('/bower/bootstrap-select/dist/css/bootstrap-select.min.css') !!}
    {!! Html::style('/bower/ztree/css/zTreeStyle/zTreeStyle.css') !!}
    {!! Html::style('/bower/jquery-ui/themes/base/jquery-ui.min.css') !!}
    {!! Html::style('/bower/bootstrap-fileinput/css/fileinput.min.css') !!}
@show

@section('center_content')
    <div class="panel panel-default">
        <div class="panel-heading">
            发布商机
        </div>

        <div class="panel-body">
            {!! Form::open(['url'=>'company/dynamic/add', 'method'=>'post',  'class'=>'form-horizontal']) !!}
            <div class="form-group form-inline">
                <div class="radio">
                    <label class="control-label">类型：</label>
                    <label><input type="radio" checked value="1" name="type">我在销售</label>
                    <label><input type="radio" checked value="2" name="type">我在求购</label>
                </div>

                <div class="radio" style="margin-top: 0px">
                    <label class="control-label">失效期：</label>
                    <input type='text' placeholder="不填即长期有效" readonly name="exp_date" id="exp_date" class="form-control" />
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-sign-in"></i> 发布
                </button>
            </div>

            <div class="form-group">
                <textarea class="form-control" rows="5" name="content"></textarea>
            </div>

            <div class="form-group">
                <input id="input-id" name="attachment" type="file" multiple>
                <input id="attachments" name="attachments" type="hidden">
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
    {!! Html::script('/bower/jquery-ui/jquery-ui.min.js') !!}
    {!! Html::script('/bower/jquery-ui/ui/i18n/datepicker-zh-CN.js') !!}
    {!! Html::script('/bower/bootstrap-fileinput/js/fileinput.min.js') !!}
    {!! Html::script('/bower/bootstrap-fileinput/themes/fa/theme.js') !!}
    {!! Html::script('/bower/bootstrap-fileinput/js/locales/zh.js') !!}
    <script>
        $('.selectpicker').selectpicker({noneSelectedText:'请选择'});

        $('.selectcategory').click(function(){
            showMenu(this);
        });

        $('#exp_date').datepicker({
            dateFormat: 'yy-mm-dd',
            showButtonPanel:true,
            minDate: 0,
            closeText: '清除',
            onClose: function (dateText, inst) {
                if ($(window.event.srcElement).hasClass('ui-datepicker-close'))
                {
                    document.getElementById(this.id).value = '';
                }
            }
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

        $("#input-id").fileinput({
            language: 'zh',
            uploadUrl: "/company/dynamic/upload",
            maxFileCount: 5,
            showUpload: true, //是否显示上传按钮
            showCaption: false,//是否显示标题
            dropZoneEnabled: false,
            browseLabel: '附件 &hellip;',
            uploadExtraData:{'_token':'{{csrf_token()}}' },
            maxFileSize: 1024*2
            /*validateInitialCount: true,*/
        }).on("fileuploaded", function (event, data) {
            //异步上传后返回结果处理
            //后台一定要返回json对象,空的也行。否则会出现提示警告。
            //返回对象的同时会显示进度条，可以根据返回值进行一些功能扩展
            console.log(data);
            if(data.response.id){
                var v = $('#attachments').val();
                if(v.length > 0){
                    v = v + ',';
                }
                v = v+data.response.id;
                $('#attachments').attr('value', v);
            }
        });

        $(document).ready(function(){
            $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        });
    </script>
@stop
