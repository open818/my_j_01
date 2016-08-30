@foreach($data as $dynamic)
    <li class="list-group-item">
        <small class="block text-muted"><i class="fa fa-clock-o"></i>{{$dynamic->created_at}} {{$dynamic->user_name}}</small>
        <p>{{$dynamic->content}}</p>
        @if(count($dynamic->attachments) > 0)
            <div class="mail-attachment">
                <p>
                    <span><i class="fa fa-paperclip"></i> {{count($dynamic->attachments)}} 个附件 - </span>
                    <a href="mail_detail.html#">下载全部</a>
                </p>

                <div class="attachment">

                    @foreach($dynamic->attachments as $att)
                    <div class="file-box">
                        <div class="file">
                            <span class="corner"></span>
                            @if(in_array($att->ext,array('png','jpg')))
                            <div class="image">
                                <img style="max-width: 200px;max-height: 200px;" alt="image" class="img-responsive" src="img/{{$att->path}}">
                            </div>
                            @else
                            <div class="icon">
                                <i class="fa fa-file"></i>
                            </div>
                            @endif

                            <div class="file-name">
                                {{$att->name}}
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="clearfix"></div>
                </div>
            </div>
        @endif
        <div class="btn-group">
            <button class="btn btn-white btn-xs"><i class="fa fa-thumbs-up"></i> 赞</button>
            <button class="btn btn-white btn-xs"><i class="fa fa-comments"></i> 评论</button>
            <button class="btn btn-white btn-xs"><i class="fa fa-share"></i> 分享</button>
        </div>
    </li>
@endforeach

