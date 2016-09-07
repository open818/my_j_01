<!-- Login -->
<div class="panel panel-default">
    <div class="panel-heading">
        功能菜单
    </div>

    <div class="panel-body">
        <ul class="nav">
            @foreach(\App\Helpers\UserMenuHelper::menu(true) as $item)
                <li>
                    <a href="{{$item['route']}}">{{$item['text']}}
                        @if(!empty($item['num']))
                            <span class="label label-warning pull-right">{{$item['num']}}</span>
                        @endif
                    </a>
                </li>
            @endforeach

            <li><a href="/logout">用户退出</a></li>
        </ul>
    </div>
</div>
