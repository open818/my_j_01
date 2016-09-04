@foreach($data as $dynamic)
    <li class="list-group-item">
        <div>
            <div class="col-md-9">
                <h5>{{$dynamic->company->name}}</h5>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary pull-right">
                    <i class="glyphicon glyphicon-plus"></i> 关注
                </button>
            </div>
        </div>

        <div>
            公司地址：{{$dynamic->company->business_address}}{{$dynamic->company->address_details}}
        </div>
        <div>
            主营品牌：<?php echo implode("、", $dynamic->company->business_brands); ?>
        </div>
        <div>
            经营类目：<?php echo implode("、", $dynamic->company->business_categories); ?>
        </div>

        <div>
            <p>{{$dynamic->content}}</p>
            @if(count($dynamic->attachments) > 0)
                <div class="mail-attachment">
                    <p>
                        <span><i class="fa fa-paperclip"></i> {{count($dynamic->attachments)}} 个附件</span>
                    </p>

                    <div class="attachment">
                        @foreach($dynamic->attachments as $att)
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

                    <small class="block text-muted"><i class="fa fa-clock-o"></i>{{$dynamic->created_at}}</small>
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
