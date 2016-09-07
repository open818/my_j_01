<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
	@section('metaLabels')
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="/">
		<meta name="description" content="">
		<meta name="author" content="">
	@show

	<link rel="icon" href="favicon.ico">
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
	<div class="container">
		@section('breadcrumbs')
			<div class="row">&nbsp;</div>
		@show
	</div>

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

{!! Html::script('/bower/jquery/dist/jquery.min.js') !!}
{!! Html::script('/bower/bootstrap/dist/js/bootstrap.min.js') !!}
{!! Html::script('/js/app.js') !!}
<script>
	$('#search_btn').click(function(){
		var key = $('#search_key').val();
		key = $.trim(key);
		if(key.length == 0){
			return '';
		}

		location.href = "search/"+key;
	});
	@if(Session::has('alert_message'))
		alert('{{Session::get('alert_message')}}');
	@endif
</script>
@section('scripts')
@show

</body>
</html>
