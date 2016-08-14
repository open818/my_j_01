@extends('layouts.master')

@section('title')@parent - 首页 @stop

@section('content')
    <section class="products_view">

        <div class="container">
            {{-- -------------------------------------------------- --}}
            {{-- ------------------ Product List ------------------ --}}
            {{-- -------------------------------------------------- --}}

            @parent

            @section('center_content')

                {{-- -------------------------------------------------- --}}
                {{-- -------------------- 广播图 -------------------- --}}
                {{-- -------------------------------------------------- --}}
                <div class="home-carousel-box">
                    <div id="store-home-carousel" class="carousel slide" data-ride="carousel">
                        {{-- indicators --}}
                        <ol class="carousel-indicators">
                            @for ($s=0; $s<count($banners); $s++)
                                <li data-target="#store-home-carousel" data-slide-to="{{ $s }}" @if ($s==0) class="active" @endif ></li>
                            @endfor
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <?php $pos = 0; ?>
                            @foreach ($banners as $banner)

                                {{-- slide items --}}
                                <div class="item @if ($pos++==0) active @endif">
                                    <img src="{{ $banner['img'] }}" alt="{{ $banner['alt'] }}" @if (isset($banner['url'])) onclick="javascript:window.location.href='{{ $banner['url'] }}'" @endif>

                                </div> {{-- end item --}}

                            @endforeach

                        </div> {{-- end carousel-inner --}}
                    </div>
                </div> {{-- end carousel --}}

                <div class="panel panel-default">
                    <div class="panel-body category">
                        <div class="box">
                            <div class="picbox">
                                <ul class="piclist mainlist">
                                    <li>aaaaaa</li>
                                    <li>aaaaaa</li>
                                    <li>aaaaaa</li>
                                    <li>aaaaaa</li>
                                    <li>aaaaaa</li>
                                    <li>aaaaaa</li>
                                    <li>aaaaaa</li>
                                    <li>aaaaaa</li>
                                    <li>aaaaaa</li>
                                    <li>aaaaaa</li>
                                    <li>aaaaaa</li>
                                    <li>aaaaaa</li>
                                    <li>aaaaaa</li>
                                    <li>aaaaaa</li>
                                    <li>aaaaaa</li>
                                </ul>
                                <ul class="piclist swaplist"></ul>
                            </div>
                            <div class="og_prev"></div>
                            <div class="og_next"></div>
                        </div>
                    </div>
                </div>

                @include('partials.company_dynamic')
            @stop {{-- end center_content --}}


            {{-- -------------------------------------------------- --}}
            {{-- -------------------- Right Bar -------------------- --}}
            {{-- -------------------------------------------------- --}}

            @section('panel_right_content')

                <div class="home-right-bar">

                    @if(Auth::user())
                        {{-- rated products tag --}}
                        @include('partials.user')
                    @else
                        {{-- rated products tag --}}
                        @include('partials.login')
                    @endif

                </div> {{-- end home-left-bar --}}

            @stop {{-- end panel_left_content --}}

        </div> {{-- end container-fluid --}}

    </section> {{-- end products_view --}}
@stop {{-- end content --}}
