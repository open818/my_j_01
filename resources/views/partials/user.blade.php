<!-- Login -->
<div class="panel panel-default">
    <div class="panel-heading">
        用户信息
    </div>

    <div class="panel-body">
        <a href="/user/profile">{{Auth::user()->name}}</a>
        <a href="/logout">用户退出</a>
    </div>
</div>
