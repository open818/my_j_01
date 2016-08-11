@include('partials.menu_top')
<div id="o-header-2016">
    <div class="w" id="header-2016">
        <div id="logo-2016" class="ld"><a href="/" hidefocus="true" ><img src="img/logo.gif" alt="京东"></a></div>
        <!--logo end-->
        <div id="search-2016">
            <div class="i-search ld">
                <div class="form">
                    {!! Form::open(['url'=>'search', 'method'=>'get', 'name'=>'searchForm', 'id'=>'searchForm', 'onSubmit'=>'return checkSearchForm()']) !!}
                        <input type="text" class="text" accesskey="s" id="key" autocomplete="off" name="keywords" id="keyword"
                               placeholder="输入商户名、品牌、类目、联系人、商圈等关键词"
                               value="@if(isset($search_keywords)){{$search_keywords}}@endif">
                        <input type="submit" value="搜索" class="button">
                    {!! Form::close() !!}
                </div>
            </div>
            @if(isset($searchkeywords))
                <div id="hotwords">
                    @foreach($searchkeywords as $key =>$val)
                        @if($key == 0)
                            <a href="search.php?keywords={{$val}}" target="_blank" style="color:#ff0000">{{$val}}</a>
                        @else
                            <a href="search.php?keywords={{$val}}" target="_blank">{{$val}}</a>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
        <!--search end-->
    </div>

</div>