<div class="navbar-wrapper container"  style="padding-top: 20px;">
    <nav class="navbar navbar-inverse navbar-static-top">
        <div>
            <div class="col-md-3">
                <a href="/" hidefocus="true" ><img src="img/logo.gif" alt="京东"></a>
            </div>

            <div class="col-md-9">
                <div class="col-md-9">
                    {!! Form::open() !!}
                    <div class="input-group">
                        <input type="text" placeholder="输入商户名、品牌、产品、联系人或其他关键词" class="form-control">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary">搜索</button>
                        </span>
                    </div>

                    {!! Form::close() !!}
                </div>

                <div class="col-md-3 navbar-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-sign-in"></i> 发布商机
                    </button>
                </div>
            </div>
        </div>

    </nav>
</div>