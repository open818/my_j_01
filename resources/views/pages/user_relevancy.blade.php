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
                <div class="row">
                    {!! Form::open(['url'=>'/user/relevancy', 'method'=>'post']) !!}
                    <div class="form-group">
                        <label for="name" class="col-md-12 control-label">选择关联公司</label>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">所属公司：</label>

                        <div class="col-md-6">
                            <input id="company_name" type="text" class="form-control" name="company_name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">所在职位：</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="position">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i> 选择关联
                            </button>
                        </div>

                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary" onclick="javascript:window.location.href='/'">
                                <i class="fa fa-btn fa-sign-in"></i> 暂不关联
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            @stop {{-- end center_content --}}

            @section('panel_left_content')
                <div class="home-left-bar">

                </div> {{-- end home-left-bar --}}

            @stop {{-- end panel_left_content --}}
        </div> {{-- end container-fluid --}}

    </section> {{-- end products_view --}}
@stop {{-- end content --}}