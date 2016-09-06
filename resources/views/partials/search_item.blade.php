@foreach($data as $company)
    <li class="list-group-item">
        <div>
            <div class="col-md-9">
                <a target="_blank" href="/company/show/{{$company->id}}"><h5>{{$company->name}}</h5></a>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary pull-right">
                    <i class="glyphicon glyphicon-plus"></i> 关注
                </button>
            </div>
        </div>

        <div>
            公司地址：{{$company->business_address}}{{$company->address_details}}
        </div>
        @if(!empty($company->business_brands))
        <div>
            主营品牌：@php($i=1) @foreach($company->business_brands as $brand) {{$brand->name}} @if($i != count($company->business_brands)) 、@php($i++) @endif @endforeach
        </div>
        @endif
        @if(!empty($dynamic->company->business_categories))
        <div>
            经营类目：@php($i=1) @foreach($company->business_categories as $cate) {{$cate->name}} @if($i != count($company->business_categories)) 、@php($i++) @endif @endforeach
        </div>
        @endif
        <div>
            <p>最新动态：{{$company->dynamic->content}}</p>
            @if(count($company->dynamic->attachments) > 0)
                <div class="mail-attachment">
                    <p>
                        <span><i class="fa fa-paperclip"></i> {{count($company->dynamic->attachments)}} 个附件</span>
                    </p>

                    <div class="attachment">
                        @foreach($company->dynamic->attachments as $att)
                            <div class="file-box">
                                <div class="file">
                                    <span class="corner"></span>
                                    <a href="file/{{$att->path}}" target="_blank">
                                        @if(in_array($att->ext,array('png','jpg','gif')))
                                            <div class="image">
                                                <img alt="image" class="img-responsive" src="img/{{$att->path}}">
                                            </div>
                                        @else

                                            <div class="icon">
                                                <i class="fa fa-file"></i>
                                            </div>
                                        @endif

                                        <div class="file-name">
                                            {{$att->name}}
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                    </div>

                    <small class="block text-muted"><i class="fa fa-clock-o"></i>发布于 {{$company->dynamic->created_at}}</small>
                </div>
            @endif
        </div>

        {{--<div class="btn-group">
            <button class="btn btn-white btn-xs"><i class="fa fa-thumbs-up"></i> 赞</button>
            <button class="btn btn-white btn-xs"><i class="fa fa-comments"></i> 评论</button>
            <button class="btn btn-white btn-xs"><i class="fa fa-share"></i> 分享</button>
        </div>--}}
    </li>
@endforeach
