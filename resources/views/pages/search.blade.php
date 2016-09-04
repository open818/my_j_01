@extends('layouts.master')

@section('title')@parent - 搜索结果 @stop

@section('content')
    <section class="products_view">

        <div class="container">
            @parent

            @section('center_content')
                <div class="panel panel-default">
                    <div class="panel-body category">
                        <div class="box">
                            <div class="picbox">
                                <ul class="piclist mainlist">
                                    <li>所有</li>
                                    @foreach(\App\Helpers\CategoryHelper::getCategory() as $category)
                                        <li>{{$category->name}}</li>
                                    @endforeach
                                </ul>
                                <ul class="piclist swaplist"></ul>
                            </div>
                            <div class="og_prev"></div>
                            <div class="og_next"></div>
                        </div>
                    </div>
                </div>

                @include('partials.dynamic')
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
