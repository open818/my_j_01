@extends('layouts.user_master')

@section('css')
    @parent
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
                    <select name="category_id" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-primary pull-right m-t-n-xs" id="btn_submit" type="button">
                    <i class="fa fa-btn fa-sign-in"></i><strong>发布</strong>
                </button>
            </div>

            <div class="form-group">
                <textarea class="form-control" rows="5" id="content" name="content"></textarea>
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
        $("#input-id").fileinput({
            language: 'zh',
            uploadUrl: "/company/dynamic/upload",
            maxFileCount: 5,
            showUpload: false, //是否显示上传按钮
            showCaption: false,//是否显示标题
            dropZoneEnabled: false,
            browseLabel: '附件 &hellip;',
            uploadExtraData:{'_token':'{{csrf_token()}}' },
            maxFileSize: 1024*2
            /*validateInitialCount: true,*/
        }).on("filebatchselected", function(event, files) {
            $(this).fileinput("upload");
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

        $('#btn_submit').click(function(){
            if($("#content").val().trim().length == 0){
                alert('内容不能为空！');
                return;
            }

            cn = $("#input-id").fileinput('getFilesCount');
            if(cn > 0){
                if(!confirm("还有"+cn+"个文件未点击上传，确定要发布数据吗？"))
                {
                    return ;
                }
            }
            this.form.submit();
        });

        $(document).ready(function(){
            $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        });
    </script>
@stop
