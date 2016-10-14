<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
	@section('metaLabels')
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="baidu-site-verification" content="hUBTJDeRlW" />
		<base href="/">
		{{--<meta name="Keywords" content="圈子,渠道,人脉,生意,圈子,商机,信息,生意,轻松,商有道">--}}
		<meta name="Keywords" content="代理商,批发市场,九星市场,北京东路,五金工具,机械设备,泵阀管件,轴承传动,紧固件,电工电气,安全防护,仪器仪表,灯饰照明,化工涂料,办公清洁,五金建材,家居家具,酒店用品,汽车用品,包装材料,物料搬运,暖通设备,商有道">
		<meta name="description" content="商有道，帮助类似上海九星市场、北京东路批发市场中的商户们经营转型，提供更简单又免费的网络渠道，建立和扩展自己的生意圈，在更宽广的市场推广自己的企业，让老客户不丢，新客户源源不断，让做生意更轻松。主要行业：五金工具、机械设备、泵阀管件、轴承传动、紧固件、电工电气、安全防护、仪器仪表、灯饰照明、化工涂料、办公清洁、五金建材、家居家具、酒店用品、汽车用品、包装材料、物料搬运、暖通设备。">
		<meta name="author" content="">
	@show

	<link rel="icon" href="favicon.ico">
	{!! Html::script('/bower/jquery/dist/jquery.min.js') !!}
	{!! Html::script('/bower/bootstrap/dist/js/bootstrap.min.js') !!}
	{!! Html::script('/js/app.js') !!}
	{!! Html::script('/js/laravel-sms.js') !!}
	<title>@section('title') 商有道 @show</title>

	{{-- CSS files --}}
	{!! Html::style('/bower/bootstrap/dist/css/bootstrap.css') !!}
	@section('css')
	{!! Html::style('/bower/font-awesome/css/font-awesome.min.css') !!}
	{!! Html::style('/css/app.css') !!}
	{!! Html::style('/css/carousel.css') !!}
	@show

	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

	<![endif]-->
</head>
<body>

<section class = "@yield('page_class', 'home')">

	{{-- Navigation bar section --}}
	@section('navigation')
		@include('partials.navigation')
	@show

	{{-- Breadcrumbs section --}}
	{{--<div class="container">
		@section('breadcrumbs')
			<div class="row">&nbsp;</div>
		@show
	</div>--}}

	{{-- Content page --}}
	@section('content')
		@section('panels')

			<div class="container">
				<div class="row">&nbsp;</div>
				<div class="row global-panels">

					{{-- left panel --}}
					@if (isset($panel['left']))
						{{-- desktops validation --}}
						<div class="col-sm-{{ $panel['left']['width'] or '2' }} col-md-{{ $panel['left']['width'] or '2' }} {{ $panel['left']['class'] or '' }}">
							@section('panel_left_content')
								Left content
							@show
						</div>
					@endif

					{{-- center content --}}
					<div class="col-xs-12 col-sm-{{ $panel['center']['width'] or '10' }} col-md-{{ $panel['center']['width'] or '10' }}">
						@section('center_content')
							Center content
						@show
					</div>

					{{-- right panel --}}
					@if (isset($panel['right']))
						<div class="hidden-xs col-sm-{{ $panel['right']['width'] or '2' }} col-md-{{ $panel['right']['width'] or '2' }} {{ $panel['right']['class'] or '' }}">
							@section('panel_right_content')
								Right content
							@show
						</div>
					@endif

				</div> {{-- globlas panels --}}
			</div> {{-- container --}}

		@show
	@show

</section>

@section('footer')
	<footer>
		{{--@include('partials.footer')--}}
	</footer>
@show

<script>
	$(function(){
		$("body").click(function(){
			//$('.popover').remove();
			var target = $(event.target);

			if (!target.hasClass('popover')
					&& !target.hasClass('pop')
					&& !target.hasClass('popover-content')
					&& !target.hasClass('popover-title')
					&& !target.hasClass('arrow')) {
				$('.popover').remove();
			}
		});

		$('#search_btn').click(function(){
			var key = $('#search_key').val();
			key = $.trim(key);
			if(key.length == 0){
				return '';
			}

			location.href = "/search/"+key;
		});

		@if(Session::has('alert_message'))
			alert('{{Session::get('alert_message')}}');
		@endif

        @if(Session::has('redirect_url'))
            location.href = '{{Session::get('redirect_url')}}';
		@endif
    });



</script>
@section('scripts')
@show

</body>
</html>
