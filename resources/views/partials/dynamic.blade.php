@foreach($data as $dynamic)
    <li class="list-group-item">
        <div class="row">
            <div class="col-md-9">
                <a target="_blank" href="/company/show/{{$dynamic->company->id}}"><h5>{{$dynamic->company->name}}</h5></a>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary pull-right">
                    <i class="glyphicon glyphicon-plus"></i> 关注
                </button>
            </div>
        </div>

        <div class="row" style="margin: 6px 0;">
            <b>{{$dynamic->user_name}}</b> 发布了一条动态
        </div>
        <div class="well">
            <p style="font-size: 16px;">{{$dynamic->content}}</p><br><br>
            @if(!empty($dynamic->attachments) && count($dynamic->attachments) > 0)
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
                                                {{$att->name}}
                                            </div>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                    </div>

                    <small class="block text-muted"><i class="fa fa-clock-o"></i>发布于 {{$dynamic->created_at}}</small>
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
