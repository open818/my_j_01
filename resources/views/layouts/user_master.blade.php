@extends('layouts.master')

@section('title')@parent - 首页 @stop

@section('content')
	<section>

		<div class="container">
			{{-- -------------------------------------------------- --}}
			{{-- ------------------ Product List ------------------ --}}
			{{-- -------------------------------------------------- --}}

			@section('panels')

				<div class="container">
					<div class="row">&nbsp;</div>
					<div class="row global-panels">

						<div class="col-sm-3 col-md-3">
							@include('partials.user_menu')
						</div>

						{{-- center content --}}
						<div class="col-xs-12 col-sm-9 col-md-9">
							@section('center_content')
								Center content
							@show
						</div>
					</div> {{-- globlas panels --}}
				</div> {{-- container --}}

			@show
		</div> {{-- end container-fluid --}}

	</section> {{-- end products_view --}}
@stop {{-- end content --}}