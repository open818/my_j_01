<div class="navbar-wrapper container"  style="padding-top: 20px;">
    <nav class="navbar navbar-inverse navbar-static-top">
        <div>
            <div class="col-md-3">
                <a href="/" hidefocus="true" ><img style="height: 80px;" src="img/logo.png" alt="商有道"></a>
            </div>

            <div class="col-md-9">
                <div class="col-md-9">
                    <div class="input-group">
                        <input id="search_key" type="text" placeholder="输入商户名、品牌、联系人或其他关键词" class="form-control" @if(isset($search_key)) value="{{$search_key}}" @endif>
                        <span class="input-group-btn">
                            <button type="button" id="search_btn" class="btn btn-primary">搜索</button>
                        </span>
                    </div>
                </div>

                <div class="col-md-3 navbar-right">
                    <a href="/company/dynamic/add" class="btn btn-primary">
                        <i class="fa fa-btn fa-sign-in"></i> 发布商机
                    </a>
                </div>
            </div>
        </div>

    </nav>
</div>