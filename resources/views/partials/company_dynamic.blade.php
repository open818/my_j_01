@foreach($data as $dynamic)
    <li class="list-group-item">
        <small class="block text-muted"><i class="fa fa-clock-o"></i>{{$dynamic->created_at}} {{$dynamic->user_name}}</small>
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
            </div>
        @endif
        {{--<div class="btn-group">
            <button class="btn btn-white btn-xs"><i class="fa fa-thumbs-up"></i> 赞</button>
            <button class="btn btn-white btn-xs"><i class="fa fa-comments"></i> 评论</button>
            <button class="btn btn-white btn-xs"><i class="fa fa-share"></i> 分享</button>
        </div>--}}
    </li>
@endforeach

