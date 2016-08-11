<div id="shortcut-2016">
	<div class="w">
		<ul class="fr lh">
			@if(\Auth::user())
				<li class="fore1" id="loginbar">
					<div class="dt">{{\Auth::user()->name}}，欢迎您！<a href="logout" class="link-logout">[退出]</a></div>
				</li>
			@else
				<li class="fore1" id="loginbar">
					<div class="dt"><span><a href="login">您好，请登录</a> <a href="register" class="link-regist" style="color:#C81623;"> [免费注册]</a></span></div>
				</li>
			@endif
			<li class="fore2 ld"><div class="dt"><s></s><a href="user.php?act=order_list">我的订单</a></div></li>
		</ul>
	</div>
</div>