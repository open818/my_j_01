<!-- Login -->
<div class="panel panel-default">
    <div class="panel-heading">
        用户信息
    </div>

    <div class="panel-body">
        {{Auth::user()->name}}
        <a href="/user/relevancy">企业关联</a>
        <a href="/logout">退出</a>
    </div>
</div>
